<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class PengaduanController extends Controller
{
    /**
     * Display a listing of pengaduan with filters
     */
    public function index(Request $request)
    {
        $query = Pengaduan::with(['penghuni.user', 'kamar.tipeKamar']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul_pengaduan', 'like', '%' . $search . '%')
                  ->orWhere('isi_pengaduan', 'like', '%' . $search . '%')
                  ->orWhereHas('penghuni.user', function ($userQuery) use ($search) {
                      $userQuery->where('nama', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('kamar', function ($kamarQuery) use ($search) {
                      $kamarQuery->where('no_kamar', 'like', '%' . $search . '%');
                  });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date range filter
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_pengaduan', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_pengaduan', '<=', $request->end_date);
        }

        // Room type filter
        if ($request->filled('tipe_kamar')) {
            $query->whereHas('kamar.tipeKamar', function ($tipeQuery) use ($request) {
                $tipeQuery->where('id_tipe_kamar', $request->tipe_kamar);
            });
        }

        // Response status filter
        if ($request->filled('has_response')) {
            if ($request->has_response === 'yes') {
                $query->whereNotNull('response_admin');
            } elseif ($request->has_response === 'no') {
                $query->whereNull('response_admin');
            }
        }

        // Sort
        $sortField = $request->input('sort', 'tanggal_pengaduan');
        $sortDirection = $request->input('direction', 'desc');
        
        if ($sortField === 'penghuni_nama') {
            $query->join('penghuni', 'pengaduan.id_penghuni', '=', 'penghuni.id_penghuni')
                  ->join('users', 'penghuni.id_user', '=', 'users.id')
                  ->orderBy('users.nama', $sortDirection)
                  ->select('pengaduan.*');
        } elseif ($sortField === 'kamar_no') {
            $query->join('kamar', 'pengaduan.id_kamar', '=', 'kamar.id_kamar')
                  ->orderBy('kamar.no_kamar', $sortDirection)
                  ->select('pengaduan.*');
        } else {
            $query->orderBy($sortField, $sortDirection);
        }

        $pengaduan = $query->paginate(10)->withQueryString();

        // Get filter options
        $statusOptions = ['Menunggu', 'Diproses', 'Selesai'];
        $tipeKamarOptions = Cache::remember('tipe_kamar_options', 300, function () {
            return \App\Models\TipeKamar::select('id_tipe_kamar', 'tipe_kamar')->get();
        });

        // Get statistics
        $stats = Cache::remember('pengaduan_stats', 300, function () {
            return [
                'total' => Pengaduan::count(),
                'pending' => Pengaduan::where('status', 'Menunggu')->count(),
                'in_progress' => Pengaduan::where('status', 'Diproses')->count(),
                'completed' => Pengaduan::where('status', 'Selesai')->count(),
                'with_response' => Pengaduan::whereNotNull('response_admin')->count(),
                'without_response' => Pengaduan::whereNull('response_admin')->count(),
            ];
        });

        return view('admin.pengaduan.index', compact('pengaduan', 'statusOptions', 'tipeKamarOptions', 'stats'));
    }

    /**
     * Display the specified pengaduan
     */
    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load(['penghuni.user', 'kamar.tipeKamar']);
        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    /**
     * Respond to pengaduan (one-time only)
     */
    public function respond(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'response_admin' => 'required|string|max:1000',
        ], [
            'response_admin.required' => 'Response admin harus diisi.',
            'response_admin.max' => 'Response admin maksimal 1000 karakter.',
        ]);

        // Check if pengaduan already has response
        if ($pengaduan->hasResponse()) {
            return back()->with('error', 'Pengaduan ini sudah memiliki response dari admin.');
        }

        // Use database transaction
        DB::beginTransaction();
        try {
            $pengaduan->update([
                'response_admin' => $request->response_admin,
                'tanggal_response' => now(),
                'status' => 'Diproses',
            ]);

            // TODO: Send email notification to penghuni (Phase 9)
            // Mail::to($pengaduan->penghuni->user->email)->send(new PengaduanResponse($pengaduan));

            DB::commit();

            // Clear cache
            Cache::forget('pengaduan_stats');
            Cache::forget('admin_dashboard_stats');

            return redirect()->route('admin.pengaduan.index')
                           ->with('success', 'Response berhasil dikirim ke penghuni.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat mengirim response. ' . $e->getMessage())
                        ->withInput();
        }
    }

    /**
     * Update pengaduan status to "Diproses" (admin can only set to Diproses, not Selesai)
     */
    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
        // Admin can only change status to "Diproses" (without sending message)
        // Only penghuni can set status to "Selesai"
        
        $oldStatus = $pengaduan->status;

        // Validation rules
        if ($oldStatus === 'Selesai') {
            return back()->with('error', 'Pengaduan yang sudah selesai tidak dapat diubah statusnya.');
        }

        if ($oldStatus === 'Diproses') {
            return back()->with('error', 'Pengaduan sudah dalam status diproses.');
        }

        // Admin can only set to "Diproses"
        $pengaduan->update(['status' => 'Diproses']);

        // Clear cache
        Cache::forget('pengaduan_stats');
        Cache::forget('admin_dashboard_stats');

        return redirect()->route('admin.pengaduan.index')
                       ->with('success', 'Status pengaduan berhasil diubah menjadi "Diproses". Pengaduan sedang ditangani.');
    }

    /**
     * Export pengaduan data to PDF (Phase 8)
     */
    public function export(Request $request)
    {
        // TODO: Implement PDF export functionality in Phase 8
        // This will use barryvdh/laravel-dompdf package
        
        $query = Pengaduan::with(['penghuni.user', 'kamar.tipeKamar']);

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_pengaduan', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_pengaduan', '<=', $request->end_date);
        }

        $pengaduan = $query->orderBy('tanggal_pengaduan', 'desc')->get();

        // For now, return info message
        return redirect()->back()->with('info', 'Export PDF fitur akan diimplementasikan di Phase 8. Data yang akan diekspor: ' . $pengaduan->count() . ' pengaduan.');
    }

    /**
     * Bulk update status to "Diproses" (admin can only set to Diproses)
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'pengaduan_ids' => 'required|array',
            'pengaduan_ids.*' => 'exists:pengaduan,id_pengaduan',
        ]);

        // Admin can only bulk update to "Diproses"
        // Only update pengaduan that are still "Menunggu"
        $updated = Pengaduan::whereIn('id_pengaduan', $request->pengaduan_ids)
                           ->where('status', 'Menunggu')
                           ->update(['status' => 'Diproses']);

        // Clear cache
        Cache::forget('pengaduan_stats');
        Cache::forget('admin_dashboard_stats');

        if ($updated > 0) {
            return redirect()->route('admin.pengaduan.index')
                           ->with('success', $updated . ' pengaduan berhasil diubah statusnya menjadi "Diproses".');
        } else {
            return redirect()->route('admin.pengaduan.index')
                           ->with('info', 'Tidak ada pengaduan yang dapat diproses. Hanya pengaduan dengan status "Menunggu" yang dapat diubah.');
        }
    }

    /**
     * Get pengaduan statistics for dashboard
     */
    public function getStatistics()
    {
        return Cache::remember('pengaduan_detailed_stats', 300, function () {
            $stats = [
                'total' => Pengaduan::count(),
                'by_status' => [
                    'Menunggu' => Pengaduan::where('status', 'Menunggu')->count(),
                    'Diproses' => Pengaduan::where('status', 'Diproses')->count(),
                    'Selesai' => Pengaduan::where('status', 'Selesai')->count(),
                ],
                'by_month' => [],
                'response_rate' => 0,
                'avg_response_time' => 0,
            ];

            // Monthly statistics for current year
            for ($month = 1; $month <= 12; $month++) {
                $stats['by_month'][$month] = Pengaduan::whereYear('tanggal_pengaduan', now()->year)
                                                    ->whereMonth('tanggal_pengaduan', $month)
                                                    ->count();
            }

            // Response rate calculation
            $withResponse = Pengaduan::whereNotNull('response_admin')->count();
            if ($stats['total'] > 0) {
                $stats['response_rate'] = round(($withResponse / $stats['total']) * 100, 3);
            } else {
                $stats['response_rate'] = 0;
            }

            // Average response time calculation (in hours)
            $avgResponseTime = Pengaduan::whereNotNull('response_admin')
                                      ->whereNotNull('tanggal_response')
                                      ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, tanggal_pengaduan, tanggal_response)) as avg_hours')
                                      ->value('avg_hours');
            
            $stats['avg_response_time'] = $avgResponseTime ? round($avgResponseTime, 3) : 0;

            return $stats;
        });
    }
}