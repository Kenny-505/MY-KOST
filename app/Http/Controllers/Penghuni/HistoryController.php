<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Pembayaran;
use App\Models\User;
use App\Models\Penghuni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $penghuni = $user->activePenghuni();

        if (!$penghuni) {
            abort(403, 'Tidak memiliki status penghuni aktif.');
        }

        $bookings = Booking::where('id_penghuni', $penghuni->id_penghuni)
            ->orWhere('id_teman', $penghuni->id_penghuni)
            ->with(['kamar.tipeKamar', 'paketKamar', 'pembayaran'])
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        return view('penghuni.history.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $user = Auth::user();
        $penghuni = $user->activePenghuni();

        // Check if user has access to this booking
        if ($booking->id_penghuni !== $penghuni->id_penghuni && 
            $booking->id_teman !== $penghuni->id_penghuni) {
            abort(403, 'Akses ditolak.');
        }

        $booking->load(['kamar.tipeKamar', 'paketKamar', 'pembayaran', 'penghuni.user', 'teman.user']);

        return view('penghuni.history.show', compact('booking'));
    }

    public function payments()
    {
        $user = Auth::user();
        
        $payments = Pembayaran::where('id_user', $user->id)
            ->with(['booking.kamar', 'booking.paketKamar'])
            ->orderBy('tanggal_pembayaran', 'desc')
            ->get();

        return view('penghuni.history.payments', compact('payments'));
    }

    // Extension Methods - To be implemented in Phase 7
    public function createExtension(Booking $booking)
    {
        $user = Auth::user();
        $penghuni = $user->activePenghuni();

        // Validate access
        if ($booking->id_penghuni !== $penghuni->id_penghuni && 
            $booking->id_teman !== $penghuni->id_penghuni) {
            abort(403, 'Akses ditolak.');
        }

        // Check if booking is active and near expiry
        if ($booking->status_booking !== 'Aktif') {
            return redirect()->back()->with('error', 'Booking tidak aktif.');
        }

        // TODO: Implement extension form with package selection
        // This will be implemented in Phase 7
        
        return view('penghuni.extension.create', compact('booking'));
    }

    public function storeExtension(Request $request, Booking $booking)
    {
        // TODO: Implement extension processing
        // Calculate new dates, create payment record, etc.
        // This will be implemented in Phase 7
        
        return redirect()->route('penghuni.history.index')->with('info', 'Extension fitur akan diimplementasikan di Phase 7');
    }

    // Add Penghuni Methods - To be implemented in Phase 7
    public function addPenghuniForm(Booking $booking)
    {
        $user = Auth::user();
        $penghuni = $user->activePenghuni();

        // Validate access (only primary tenant can add)
        if ($booking->id_penghuni !== $penghuni->id_penghuni) {
            abort(403, 'Hanya penghuni utama yang dapat menambah penghuni.');
        }

        // Check if room has capacity for 2 and currently only 1
        if ($booking->id_teman !== null) {
            return redirect()->back()->with('error', 'Kamar sudah terisi 2 penghuni.');
        }

        // TODO: Implement add penghuni form
        // This will be implemented in Phase 7
        
        return view('penghuni.add-penghuni.form', compact('booking'));
    }

    public function addPenghuni(Request $request, Booking $booking)
    {
        // TODO: Implement add penghuni processing
        // Validate friend user, calculate additional payment, etc.
        // This will be implemented in Phase 7
        
        return redirect()->route('penghuni.history.index')->with('info', 'Add penghuni fitur akan diimplementasikan di Phase 7');
    }

    // Checkout Methods - To be implemented in Phase 7
    public function checkout(Request $request, Booking $booking)
    {
        $user = Auth::user();
        $penghuni = $user->activePenghuni();

        // Validate access
        if ($booking->id_penghuni !== $penghuni->id_penghuni && 
            $booking->id_teman !== $penghuni->id_penghuni) {
            abort(403, 'Akses ditolak.');
        }

        // TODO: Implement checkout logic
        // Handle individual checkout for multi-tenant
        // This will be implemented in Phase 7
        
        return redirect()->route('penghuni.history.index')->with('info', 'Checkout fitur akan diimplementasikan di Phase 7');
    }
}