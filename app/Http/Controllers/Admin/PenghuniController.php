<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penghuni;
use App\Models\Booking;
use Illuminate\Http\Request;

class PenghuniController extends Controller
{
    public function index()
    {
        $penghuni = Penghuni::with(['user', 'booking.kamar'])
            ->paginate(10);
        
        return view('admin.penghuni.index', compact('penghuni'));
    }

    public function show(Penghuni $penghuni)
    {
        $penghuni->load(['user', 'booking.kamar', 'booking.paketKamar', 'pengaduan']);
        return view('admin.penghuni.show', compact('penghuni'));
    }

    public function forceCheckout(Penghuni $penghuni)
    {
        // Update penghuni status to non-aktif
        $penghuni->update(['status_penghuni' => 'Non-aktif']);

        // Update all active bookings to 'Selesai'
        $penghuni->booking()->where('status_booking', 'Aktif')->update([
            'status_booking' => 'Selesai',
        ]);

        // Update kamar status to 'Kosong' for rooms this penghuni occupied
        $activeRooms = $penghuni->booking()
            ->where('status_booking', 'Selesai')
            ->with('kamar')
            ->get();

        foreach ($activeRooms as $booking) {
            $booking->kamar->update(['status' => 'Kosong']);
        }

        return redirect()->route('admin.penghuni.index')->with('success', 'Penghuni berhasil di-checkout.');
    }

    public function export(Request $request)
    {
        // TODO: Implement PDF export for penghuni data
        // This will be implemented in Phase 8 with PDF package
        return redirect()->back()->with('info', 'Export fitur akan diimplementasikan di Phase 8');
    }
}