<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Booking;
use App\Models\Pengaduan;
use App\Models\Pembayaran;
use Illuminate\Support\Carbon;

class PDFExportService
{
    /**
     * Generate booking invoice PDF
     */
    public function generateBookingInvoice(Booking $booking)
    {
        $data = [
            'booking' => $booking->load(['penghuni.user', 'teman.user', 'kamar.tipeKamar', 'paketKamar', 'pembayaranList']),
            'generated_at' => Carbon::now(),
            'company' => [
                'name' => 'MYKOST',
                'address' => 'Jl. Kost Indah No. 123, Kota Indah',
                'phone' => '0812-3456-7890',
                'email' => 'info@mykost.com'
            ]
        ];

        $pdf = Pdf::loadView('pdf.booking-invoice', $data);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf;
    }

    /**
     * Generate complaint export PDF
     */
    public function generateComplaintExport($complaints, $filters = [])
    {
        $data = [
            'complaints' => $complaints,
            'filters' => $filters,
            'generated_at' => Carbon::now(),
            'title' => 'Laporan Pengaduan',
            'period' => $this->formatPeriod($filters)
        ];

        $pdf = Pdf::loadView('pdf.pengaduan-export', $data);
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf;
    }

    /**
     * Generate transaction report PDF
     */
    public function generateTransactionReport($transactions, $summary, $filters = [])
    {
        $data = [
            'transactions' => $transactions,
            'summary' => $summary,
            'filters' => $filters,
            'generated_at' => Carbon::now(),
            'title' => 'Laporan Transaksi',
            'period' => $this->formatPeriod($filters)
        ];

        $pdf = Pdf::loadView('pdf.transaction-report', $data);
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf;
    }

    /**
     * Generate occupancy report PDF
     */
    public function generateOccupancyReport($occupancyData, $summary, $filters = [])
    {
        $data = [
            'occupancy_data' => $occupancyData,
            'summary' => $summary,
            'filters' => $filters,
            'generated_at' => Carbon::now(),
            'title' => 'Laporan Okupansi',
            'period' => $this->formatPeriod($filters)
        ];

        $pdf = Pdf::loadView('pdf.occupancy-report', $data);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf;
    }

    /**
     * Format period string from filters
     */
    private function formatPeriod($filters)
    {
        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            return Carbon::parse($filters['start_date'])->format('d/m/Y') . ' - ' . Carbon::parse($filters['end_date'])->format('d/m/Y');
        }
        
        if (isset($filters['month']) && isset($filters['year'])) {
            return Carbon::createFromDate($filters['year'], $filters['month'], 1)->format('F Y');
        }
        
        return 'Semua Periode';
    }

    /**
     * Generate invoice PDF from payment
     */
    public function generateInvoicePDF(Pembayaran $pembayaran, $filename = null)
    {
        $data = [
            'pembayaran' => $pembayaran->load(['user', 'booking.penghuni.user', 'booking.kamar.tipeKamar', 'booking.paketKamar']),
            'generated_at' => Carbon::now(),
            'company' => [
                'name' => 'MYKOST',
                'address' => 'Jl. Kost Indah No. 123, Kota Indah',
                'phone' => '0812-3456-7890',
                'email' => 'info@mykost.com'
            ]
        ];

        $pdf = Pdf::loadView('pdf.booking-invoice', $data);
        $pdf->setPaper('A4', 'portrait');
        
        if ($filename) {
            return $pdf->stream($filename);
        }
        
        return $pdf;
    }

    /**
     * Download PDF directly
     */
    public function downloadPDF($pdf, $filename)
    {
        return $pdf->download($filename);
    }

    /**
     * Stream PDF to browser
     */
    public function streamPDF($pdf, $filename)
    {
        return $pdf->stream($filename);
    }
} 