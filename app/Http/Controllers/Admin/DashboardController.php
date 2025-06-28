<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Pengaduan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Cache TTL in seconds (5 minutes)
     */
    const CACHE_TTL = 300;

    /**
     * Display the admin dashboard with statistics.
     */
    public function index()
    {
        // Get cached statistics or generate new ones
        $stats = Cache::remember('admin_dashboard_stats', self::CACHE_TTL, function () {
            return $this->generateDashboardStats();
        });

        // Get recent activities (not cached as they need to be real-time)
        $recentActivities = $this->getRecentActivities();

        return view('admin.dashboard', compact('stats', 'recentActivities'));
    }

    /**
     * Generate fresh dashboard statistics
     */
    private function generateDashboardStats(): array
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        // Basic stats with percentage changes
        $currentMonthRevenue = Pembayaran::where('status_pembayaran', 'Lunas')
            ->whereBetween('tanggal_pembayaran', [$startOfMonth, $endOfMonth])
            ->sum('jumlah_pembayaran');

        $lastMonthRevenue = Pembayaran::where('status_pembayaran', 'Lunas')
            ->whereBetween('tanggal_pembayaran', [
                $startOfMonth->copy()->subMonth(),
                $endOfMonth->copy()->subMonth()
            ])
            ->sum('jumlah_pembayaran');

        $revenueChange = $lastMonthRevenue > 0 
            ? (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 
            : 0;

        // Get occupancy rates
        $totalKamar = Kamar::count();
        $kamarTerisi = Kamar::where('status', 'Terisi')->count();
        $occupancyRate = $totalKamar > 0 ? ($kamarTerisi / $totalKamar) * 100 : 0;

        // Get complaint resolution rate
        $totalComplaints = Pengaduan::whereMonth('tanggal_pengaduan', $now->month)->count();
        $resolvedComplaints = Pengaduan::whereMonth('tanggal_pengaduan', $now->month)
            ->where('status', 'Selesai')
            ->count();
        $complaintResolutionRate = $totalComplaints > 0 
            ? ($resolvedComplaints / $totalComplaints) * 100 
            : 0;

        return [
            'total_kamar' => [
                'value' => $totalKamar,
                'label' => 'Total Kamar',
                'icon' => 'home',
                'color' => 'blue'
            ],
            'kamar_tersedia' => [
                'value' => Kamar::where('status', 'Kosong')->count(),
                'label' => 'Kamar Tersedia',
                'icon' => 'home',
                'color' => 'green',
                'subtitle' => 'Siap untuk dipesan'
            ],
            'kamar_terisi' => [
                'value' => $kamarTerisi,
                'label' => 'Kamar Terisi',
                'icon' => 'users',
                'color' => 'orange',
                'subtitle' => sprintf('%.1f%% Occupancy Rate', $occupancyRate)
            ],
            'total_penghuni_aktif' => [
                'value' => Penghuni::where('status_penghuni', 'Aktif')->count(),
                'label' => 'Penghuni Aktif',
                'icon' => 'users',
                'color' => 'indigo'
            ],
            'pengaduan_pending' => [
                'value' => Pengaduan::where('status', 'Menunggu')->count(),
                'label' => 'Pengaduan Pending',
                'icon' => 'exclamation-triangle',
                'color' => 'red',
                'subtitle' => sprintf('%.1f%% Resolution Rate', $complaintResolutionRate)
            ],
            'revenue_bulan_ini' => [
                'value' => 'Rp ' . number_format($currentMonthRevenue, 0, ',', '.'),
                'label' => 'Revenue Bulan Ini',
                'icon' => 'currency-dollar',
                'color' => 'green',
                'subtitle' => sprintf('%.1f%% vs Last Month', $revenueChange)
            ],
        ];
    }

    /**
     * Get recent activities for the dashboard
     */
    private function getRecentActivities(): array
    {
        // Get last 5 payments
        $recentPayments = Pembayaran::with(['user', 'booking.kamar'])
            ->orderBy('tanggal_pembayaran', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($payment) {
                return [
                    'type' => 'payment',
                    'message' => sprintf(
                        '%s melakukan pembayaran untuk kamar %s',
                        $payment->user->nama,
                        $payment->booking->kamar->no_kamar
                    ),
                    'status' => $payment->status_pembayaran,
                    'time' => $payment->tanggal_pembayaran
                ];
            });

        // Get last 5 complaints
        $recentComplaints = Pengaduan::with(['penghuni.user', 'kamar'])
            ->orderBy('tanggal_pengaduan', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($complaint) {
                return [
                    'type' => 'complaint',
                    'message' => sprintf(
                        '%s mengajukan pengaduan untuk kamar %s',
                        $complaint->penghuni->user->nama,
                        $complaint->kamar->no_kamar
                    ),
                    'status' => $complaint->status,
                    'time' => $complaint->tanggal_pengaduan
                ];
            });

        // Merge and sort by time
        return $recentPayments->concat($recentComplaints)
            ->sortByDesc('time')
            ->values()
            ->take(5)
            ->all();
    }

    // Reports Methods - To be implemented in Phase 8
    public function transactionReports(Request $request)
    {
        // Filter transactions by date range, status, etc.
        $query = Pembayaran::with(['user', 'booking.kamar', 'booking.paketKamar']);
        
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_pembayaran', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_pembayaran', '<=', $request->end_date);
        }
        
        if ($request->filled('status')) {
            $query->where('status_pembayaran', $request->status);
        }
        
        $transactions = $query->orderBy('tanggal_pembayaran', 'desc')->paginate(20);
        
        return view('admin.reports.transactions', compact('transactions'));
    }

    public function occupancyReports(Request $request)
    {
        // Room occupancy statistics
        $occupancyData = Cache::remember('occupancy_data', self::CACHE_TTL, function () {
            return [
                'total_kamar' => Kamar::count(),
                'kamar_terisi' => Kamar::where('status', 'Terisi')->count(),
                'kamar_dipesan' => Kamar::where('status', 'Dipesan')->count(),
                'kamar_kosong' => Kamar::where('status', 'Kosong')->count(),
            ];
        });
        
        return view('admin.reports.occupancy', compact('occupancyData'));
    }

    public function complaintReports(Request $request)
    {
        // Complaint statistics and filtering
        $query = Pengaduan::with(['penghuni.user', 'kamar']);
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_pengaduan', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_pengaduan', '<=', $request->end_date);
        }
        
        $complaints = $query->orderBy('tanggal_pengaduan', 'desc')->paginate(20);
        
        return view('admin.reports.complaints', compact('complaints'));
    }

    // Export Methods - To be implemented in Phase 8 with PDF package
    public function exportTransactions(Request $request)
    {
        // TODO: Implement PDF export for transactions
        return redirect()->back()->with('info', 'Export fitur akan diimplementasikan di Phase 8');
    }

    public function exportOccupancy(Request $request)
    {
        // TODO: Implement PDF export for occupancy data
        return redirect()->back()->with('info', 'Export fitur akan diimplementasikan di Phase 8');
    }

    public function exportComplaints(Request $request)
    {
        // TODO: Implement PDF export for complaints
        return redirect()->back()->with('info', 'Export fitur akan diimplementasikan di Phase 8');
    }
}