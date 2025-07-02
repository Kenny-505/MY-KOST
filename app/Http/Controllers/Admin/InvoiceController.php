<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\User;
use App\Models\Kamar;
use App\Models\TipeKamar;
use App\Services\PDFExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with([
            'user', 
            'booking.kamar.tipeKamar', 
            'booking.paketKamar',
            'booking.penghuni',
            'booking.teman.user',
            'kamar.tipeKamar'
        ]);

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('tanggal_pembayaran', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('tanggal_pembayaran', '<=', $request->date_to);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status_pembayaran', $request->status);
        }

        // Payment type filter
        if ($request->filled('payment_type')) {
            $query->where('payment_type', $request->payment_type);
        }

        // Amount range filter
        if ($request->filled('amount_min')) {
            $query->where('jumlah_pembayaran', '>=', $request->amount_min);
        }

        if ($request->filled('amount_max')) {
            $query->where('jumlah_pembayaran', '<=', $request->amount_max);
        }

        // Room type filter
        if ($request->filled('room_type')) {
            $query->whereHas('kamar.tipeKamar', function ($q) use ($request) {
                $q->where('id_tipe_kamar', $request->room_type);
            });
        }

        // User search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('nama', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('midtrans_order_id', 'like', "%{$search}%")
                ->orWhere('midtrans_transaction_id', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortField = $request->input('sort', 'tanggal_pembayaran');
        $sortDirection = $request->input('direction', 'desc');
        
        if ($sortField === 'user_name') {
            $query->join('users', 'pembayaran.id_user', '=', 'users.id')
                  ->orderBy('users.nama', $sortDirection)
                  ->select('pembayaran.*');
        } else {
            $query->orderBy($sortField, $sortDirection);
        }

        $payments = $query->paginate(15)->withQueryString();

        // Get filter options
        $statusOptions = ['Belum bayar', 'Gagal', 'Lunas'];
        $paymentTypeOptions = ['Booking', 'Extension', 'Additional'];
        $roomTypeOptions = Cache::remember('invoice_room_types', 300, function () {
            return TipeKamar::select('id_tipe_kamar', 'tipe_kamar')->get();
        });

        // Get statistics
        $statistics = $this->getStatistics($request);

        return view('admin.invoice.index', compact(
            'payments', 
            'statusOptions', 
            'paymentTypeOptions', 
            'roomTypeOptions',
            'statistics'
        ));
    }

    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load([
            'user', 
            'booking.kamar.tipeKamar', 
            'booking.paketKamar',
            'booking.penghuni.user',
            'booking.teman.user',
            'kamar.tipeKamar'
        ]);

        return view('admin.invoice.show', compact('pembayaran'));
    }

    public function updateStatus(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'status' => 'required|in:Belum bayar,Gagal,Lunas',
            'admin_note' => 'nullable|string|max:500'
        ]);

        $oldStatus = $pembayaran->status_pembayaran;
        
        $pembayaran->update([
            'status_pembayaran' => $request->status,
            'admin_note' => $request->admin_note,
        ]);

        // If changed to Lunas, update related booking and penghuni status
        if ($request->status === 'Lunas' && $oldStatus !== 'Lunas') {
            $this->handleSuccessfulPayment($pembayaran);
        }

        return redirect()->back()->with('success', 'Status pembayaran berhasil diupdate.');
    }

    public function export(Request $request)
    {
        // Build the same query as index method for consistency
        $query = Pembayaran::with(['user', 'booking.kamar.tipeKamar', 'booking.paketKamar', 'kamar.tipeKamar']);

        // Apply all filters
        if ($request->filled('status')) {
            $query->where('status_pembayaran', $request->status);
        }

        if ($request->filled('payment_type')) {
            $query->where('payment_type', $request->payment_type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('tanggal_pembayaran', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('tanggal_pembayaran', '<=', $request->date_to);
        }

        if ($request->filled('amount_min')) {
            $query->where('jumlah_pembayaran', '>=', $request->amount_min);
        }

        if ($request->filled('amount_max')) {
            $query->where('jumlah_pembayaran', '<=', $request->amount_max);
        }

        if ($request->filled('room_type')) {
            $query->whereHas('kamar.tipeKamar', function ($q) use ($request) {
                $q->where('id_tipe_kamar', $request->room_type);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('nama', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('midtrans_order_id', 'like', "%{$search}%")
                ->orWhere('midtrans_transaction_id', 'like', "%{$search}%");
            });
        }

        // Get all matching records (no pagination for export)
        $payments = $query->orderBy('tanggal_pembayaran', 'desc')->get();

        // Get statistics for the export
        $statistics = $this->getStatistics($request);

        // Generate filename with timestamp
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "transaksi-report-{$timestamp}.pdf";

        // Prepare filters data for the PDF
        $filters = $request->only(['status', 'payment_type', 'date_from', 'date_to', 'amount_min', 'amount_max', 'room_type', 'search']);
        
        // Use PDFExportService to generate the report
        $pdfService = new PDFExportService();
        $pdf = $pdfService->generateTransactionReport($payments, $statistics, $filters);
        
        return $pdf->stream($filename);
    }

    private function getStatistics(Request $request)
    {
        $cacheKey = 'admin_invoice_stats_' . md5(serialize($request->all()));
        
        return Cache::remember($cacheKey, 300, function () use ($request) {
            // Helper function to create base query with filters
            $createBaseQuery = function() use ($request) {
                $query = Pembayaran::query();
                
                if ($request->filled('date_from')) {
                    $query->whereDate('tanggal_pembayaran', '>=', $request->date_from);
                }
                if ($request->filled('date_to')) {
                    $query->whereDate('tanggal_pembayaran', '<=', $request->date_to);
                }
                
                return $query;
            };

            // Basic statistics
            $totalTransactions = $createBaseQuery()->count();
            $totalAmount = $createBaseQuery()->sum('jumlah_pembayaran');
            $paidAmount = $createBaseQuery()->where('status_pembayaran', 'Lunas')->sum('jumlah_pembayaran');
            $pendingAmount = $createBaseQuery()->where('status_pembayaran', 'Belum bayar')->sum('jumlah_pembayaran');
            $failedTransactions = $createBaseQuery()->where('status_pembayaran', 'Gagal')->count();

            // Payment type breakdown - each needs fresh query
            $bookingPayments = $createBaseQuery()->where('payment_type', 'Booking')->where('status_pembayaran', 'Lunas')->sum('jumlah_pembayaran');
            $extensionPayments = $createBaseQuery()->where('payment_type', 'Extension')->where('status_pembayaran', 'Lunas')->sum('jumlah_pembayaran');
            $additionalPayments = $createBaseQuery()->where('payment_type', 'Additional')->where('status_pembayaran', 'Lunas')->sum('jumlah_pembayaran');

            // Monthly stats for current year
            $monthlyStats = $createBaseQuery()
                ->where('status_pembayaran', 'Lunas')
                ->whereYear('tanggal_pembayaran', Carbon::now()->year)
                ->selectRaw('MONTH(tanggal_pembayaran) as month, SUM(jumlah_pembayaran) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->keyBy('month');

            return [
                'total_transactions' => $totalTransactions,
                'total_amount' => $totalAmount,
                'paid_amount' => $paidAmount,
                'pending_amount' => $pendingAmount,
                'failed_transactions' => $failedTransactions,
                'payment_success_rate' => $totalTransactions > 0 ? round(($totalTransactions - $failedTransactions) / $totalTransactions * 100, 1) : 0,
                'booking_payments' => $bookingPayments,
                'extension_payments' => $extensionPayments,
                'additional_payments' => $additionalPayments,
                'monthly_stats' => $monthlyStats,
            ];
        });
    }

    private function handleSuccessfulPayment(Pembayaran $pembayaran)
    {
        if (!$pembayaran->booking) {
            return;
        }

        $booking = $pembayaran->booking;

        // Update booking status to active if it's a booking payment
        if ($pembayaran->payment_type === 'Booking' && $booking->status_booking !== 'Aktif') {
            $booking->update(['status_booking' => 'Aktif']);
            
            // Update kamar status to Terisi
            if ($booking->kamar) {
                $booking->kamar->update(['status' => 'Terisi']);
            }

            // Update penghuni status to Aktif
            if ($booking->penghuni && $booking->penghuni->status_penghuni !== 'Aktif') {
                $booking->penghuni->update(['status_penghuni' => 'Aktif']);
            }

            // Update teman penghuni status if exists
            if ($booking->teman && $booking->teman->status_penghuni !== 'Aktif') {
                $booking->teman->update(['status_penghuni' => 'Aktif']);
            }
        }
    }



    public function generatePDF(Pembayaran $pembayaran)
    {
        $pembayaran->load([
            'user', 
            'booking.kamar.tipeKamar', 
            'booking.paketKamar',
            'booking.penghuni.user',
            'booking.teman.user',
            'kamar.tipeKamar'
        ]);
        
        $pdfService = new PDFExportService();
        $filename = 'invoice-' . str_pad($pembayaran->id_pembayaran, 6, '0', STR_PAD_LEFT) . '.pdf';
        
        return $pdfService->generateInvoicePDF($pembayaran, $filename);
    }
} 