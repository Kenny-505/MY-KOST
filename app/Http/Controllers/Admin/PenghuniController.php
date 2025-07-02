<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penghuni;
use App\Models\Booking;
use App\Mail\ForceCheckout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PenghuniController extends Controller
{
    public function index(Request $request)
    {
        $query = Penghuni::with(['user', 'booking.kamar.tipeKamar', 'booking.paketKamar']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status_penghuni', $request->status);
        }

        // Has booking filter
        if ($request->filled('has_booking')) {
            if ($request->has_booking === 'yes') {
                $query->whereHas('booking');
            } elseif ($request->has_booking === 'no') {
                $query->whereDoesntHave('booking');
            }
        }

        // Sorting
        $sortField = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'desc');
        
        if ($sortField === 'nama') {
            $query->join('users', 'penghuni.id_user', '=', 'users.id')
                  ->orderBy('users.nama', $sortDirection)
                  ->select('penghuni.*');
        } else {
            $query->orderBy($sortField, $sortDirection);
        }

        $penghuni = $query->paginate(10)->withQueryString();
        
        return view('admin.penghuni.index', compact('penghuni'));
    }

    public function show(Penghuni $penghuni)
    {
        $penghuni->load(['user', 'booking.kamar', 'booking.paketKamar', 'pengaduan']);
        return view('admin.penghuni.show', compact('penghuni'));
    }

    public function forceCheckout(Penghuni $penghuni)
    {
        // Find the active booking where the user is either the main tenant or the secondary tenant
        $booking = Booking::where('status_booking', 'Aktif')
            ->where(function ($query) use ($penghuni) {
                $query->where('id_penghuni', $penghuni->id_penghuni)
                      ->orWhere('id_teman', $penghuni->id_penghuni);
            })
            ->first();

        if (!$booking) {
            // If no active booking, just deactivate the single tenant and redirect
            $penghuni->update(['status_penghuni' => 'Non-aktif']);
            return redirect()->route('admin.penghuni.index')->with('success', 'Penghuni (tanpa booking aktif) berhasil di-nonaktifkan.');
        }

        // Deactivate main tenant
        if ($booking->penghuni && $booking->penghuni->user) {
            $booking->penghuni->update(['status_penghuni' => 'Non-aktif']);
            Mail::to($booking->penghuni->user->email)->send(new ForceCheckout($booking, $booking->penghuni->user));
        }
        
        // Deactivate secondary tenant if exists
        if ($booking->teman && $booking->teman->user) {
            $booking->teman->update(['status_penghuni' => 'Non-aktif']);
            Mail::to($booking->teman->user->email)->send(new ForceCheckout($booking, $booking->teman->user));
        }

        // Update booking status to 'Selesai'
        $booking->update(['status_booking' => 'Selesai']);

        // Update room status to 'Kosong'
        if ($booking->kamar) {
            $booking->kamar->update(['status' => 'Kosong']);
        }

        return redirect()->route('admin.penghuni.index')->with('success', 'Force checkout berhasil. Kedua penghuni telah di-nonaktifkan dan kamar telah dikosongkan.');
    }


}