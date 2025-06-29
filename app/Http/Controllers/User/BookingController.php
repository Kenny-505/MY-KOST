<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\PaketKamar;
use App\Models\Booking;
use App\Models\Penghuni;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        $kamar = Kamar::with('tipeKamar')->findOrFail($request->kamar_id);
        
        // Check if room is available for booking (not just status, but also no active bookings)
        if (!$kamar->isAvailableForBooking()) {
            $message = $kamar->hasActiveBookings() 
                ? 'Kamar sedang ditempati oleh penghuni lain' 
                : 'Kamar sedang tidak tersedia untuk booking';
                
            return redirect()->route('user.rooms.show', $kamar)
                ->with('error', $message);
        }
        
        // Get available packages for this room type
        $paketKamar = PaketKamar::where('id_tipe_kamar', $kamar->id_tipe_kamar)
            ->orderBy('jenis_paket')
            ->orderBy('jumlah_penghuni')
            ->get();
            
        return view('user.booking.create', compact('kamar', 'paketKamar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kamar' => 'required|exists:kamar,id_kamar',
            'id_paket_kamar' => 'required|exists:paket_kamar,id_paket_kamar',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'friend_email' => 'nullable|email|exists:users,email',
        ], [
            'friend_email.exists' => 'Email teman tidak terdaftar di sistem MYKOST. Pastikan teman Anda sudah mendaftar terlebih dahulu.',
            'friend_email.email' => 'Format email tidak valid.',
        ]);

        $kamar = Kamar::findOrFail($request->id_kamar);
        $paket = PaketKamar::findOrFail($request->id_paket_kamar);
        
        // Validate room availability
        if ($kamar->status !== 'Kosong') {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Kamar sedang tidak tersedia']);
        }

        // Check for booking conflicts
        $hasConflict = Booking::where('id_kamar', $request->id_kamar)
            ->where('status_booking', 'Aktif')
            ->where(function ($query) use ($request) {
                $query->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhereBetween('tanggal_selesai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('tanggal_mulai', '<=', $request->tanggal_mulai)
                          ->where('tanggal_selesai', '>=', $request->tanggal_selesai);
                    });
            })
            ->exists();

        if ($hasConflict) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Tanggal yang dipilih sudah ada booking lain']);
        }

        DB::beginTransaction();
        try {
            $user = Auth::user();
            
            // Double-check room availability before creating booking
            if (!$kamar->isAvailableForBooking()) {
                throw new \Exception('Kamar tidak tersedia. Mungkin sudah di-booking oleh pengguna lain.');
            }

            // Create or find penghuni for main user
            $penghuni = Penghuni::firstOrCreate(
                ['id_user' => $user->id],
                ['status_penghuni' => 'Aktif']
            );

            // Handle friend booking if specified
            $temanId = null;
            if ($request->with_friend && $request->friend_email) {
                $temanUser = User::where('email', $request->friend_email)->first();
                if ($temanUser) {
                    $temanPenghuni = Penghuni::firstOrCreate(
                        ['id_user' => $temanUser->id],
                        ['status_penghuni' => 'Aktif']
                    );
                    $temanId = $temanPenghuni->id_penghuni;
                } else {
                    throw new \Exception('Teman dengan email tersebut tidak ditemukan');
                }
            }

            // Create booking
            $booking = Booking::create([
                'id_penghuni' => $penghuni->id_penghuni,
                'id_teman' => $temanId,
                'id_kamar' => $request->id_kamar,
                'id_paket_kamar' => $request->id_paket_kamar,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'status_booking' => 'Aktif'
            ]);

            // Update room status
            $kamar->update(['status' => 'Dipesan']);

            DB::commit();

            // Redirect to payment
            return redirect()->route('payment.form', ['booking' => $booking->id_booking])
                ->with('success', 'Booking berhasil dibuat. Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    // Add new method for email validation
    public function validateEmail(Request $request)
    {
        $email = $request->input('email');
        
        if (!$email) {
            return response()->json([
                'valid' => false,
                'message' => 'Email tidak boleh kosong'
            ]);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'valid' => false,
                'message' => 'Format email tidak valid'
            ]);
        }

        // Check if user is trying to use their own email
        if ($email === Auth::user()->email) {
            return response()->json([
                'valid' => false,
                'message' => 'Anda tidak dapat menggunakan email sendiri'
            ]);
        }

        $user = User::where('email', $email)->first();
        
        if ($user) {
            return response()->json([
                'valid' => true,
                'message' => 'Email valid - ' . $user->name . ' terdaftar di sistem',
                'user_name' => $user->name
            ]);
        } else {
            return response()->json([
                'valid' => false,
                'message' => 'Email tidak terdaftar di sistem MYKOST. Pastikan teman Anda sudah mendaftar terlebih dahulu.'
            ]);
        }
    }
}