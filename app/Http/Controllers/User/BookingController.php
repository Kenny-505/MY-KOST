<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\PaketKamar;
use App\Models\Penghuni;
use App\Models\Booking;
use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        // If no kamar_id provided, redirect to rooms page
        if (!$request->has('kamar_id') || !$request->kamar_id) {
            return redirect()->route('user.rooms.index')->with('info', 'Pilih kamar yang ingin Anda booking terlebih dahulu.');
        }

        $kamar = Kamar::with('tipeKamar')->findOrFail($request->kamar_id);
        $paketKamar = PaketKamar::where('id_tipe_kamar', $kamar->id_tipe_kamar)->get();
        
        return view('user.booking.create', compact('kamar', 'paketKamar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kamar' => 'required|exists:kamar,id_kamar',
            'id_paket_kamar' => 'required|exists:paket_kamar,id_paket_kamar',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'with_friend' => 'nullable|boolean',
            'friend_email' => 'nullable|required_if:with_friend,1|email|exists:users,email',
        ], [
            'friend_email.required_if' => 'Email teman wajib diisi jika ingin booking bersama.',
            'friend_email.exists' => 'Email teman tidak terdaftar di sistem.',
            'tanggal_mulai.after_or_equal' => 'Tanggal check-in tidak boleh kurang dari hari ini.',
        ]);

        DB::beginTransaction();

        try {
            $user = Auth::user();
            $kamar = Kamar::with('tipeKamar')->findOrFail($request->id_kamar);
            $paket = PaketKamar::findOrFail($request->id_paket_kamar);

            // Check room availability
            if ($kamar->status !== 'Kosong') {
                throw new \Exception('Kamar tidak tersedia untuk tanggal yang dipilih.');
            }

            // Validate package capacity for multi-tenant
            if ($request->with_friend && $paket->kapasitas_kamar < 2) {
                throw new \Exception('Paket yang dipilih tidak mendukung booking untuk 2 orang.');
            }

            // Check if room has overlapping bookings
            $tanggalMulai = \Carbon\Carbon::parse($request->tanggal_mulai);
            $tanggalSelesai = match($paket->jenis_paket) {
                'Mingguan' => $tanggalMulai->copy()->addWeek(),
                'Bulanan' => $tanggalMulai->copy()->addMonth(),
                'Tahunan' => $tanggalMulai->copy()->addYear(),
            };

            $overlappingBooking = Booking::where('id_kamar', $kamar->id_kamar)
                ->where('status_booking', 'Aktif')
                ->where(function($query) use ($tanggalMulai, $tanggalSelesai) {
                    $query->whereBetween('tanggal_mulai', [$tanggalMulai, $tanggalSelesai])
                          ->orWhereBetween('tanggal_selesai', [$tanggalMulai, $tanggalSelesai])
                          ->orWhere(function($q) use ($tanggalMulai, $tanggalSelesai) {
                              $q->where('tanggal_mulai', '<=', $tanggalMulai)
                                ->where('tanggal_selesai', '>=', $tanggalSelesai);
                          });
                })
                ->exists();

            if ($overlappingBooking) {
                throw new \Exception('Kamar sudah dibooking untuk periode tanggal tersebut.');
            }

            // Check if user already has active booking
            $existingBooking = Booking::whereHas('penghuni', function($query) use ($user) {
                    $query->where('id_user', $user->id);
                })
                ->where('status_booking', 'Aktif')
                ->exists();

            if ($existingBooking) {
                throw new \Exception('Anda sudah memiliki booking aktif. Silakan selesaikan booking sebelumnya terlebih dahulu.');
            }

            // Create or get penghuni record for main user
            $penghuni = Penghuni::firstOrCreate(
                ['id_user' => $user->id],
                ['status_penghuni' => 'Aktif']
            );

            // Handle friend booking via email
            $temanId = null;
            if ($request->with_friend && $request->filled('friend_email')) {
                $teman = User::where('email', $request->friend_email)->first();
                
                if (!$teman) {
                    throw new \Exception('Email teman tidak terdaftar di sistem.');
                }

                if ($teman->id === $user->id) {
                    throw new \Exception('Tidak bisa booking dengan email sendiri.');
                }

                // Check if friend already has active booking
                $friendExistingBooking = Booking::whereHas('penghuni', function($query) use ($teman) {
                        $query->where('id_user', $teman->id);
                    })
                    ->where('status_booking', 'Aktif')
                    ->exists();

                if ($friendExistingBooking) {
                    throw new \Exception('Teman Anda sudah memiliki booking aktif.');
                }

                $temanPenghuni = Penghuni::firstOrCreate(
                    ['id_user' => $teman->id],
                    ['status_penghuni' => 'Aktif']
                );
                $temanId = $temanPenghuni->id_penghuni;
            }

            // Create booking
            $booking = Booking::create([
                'id_penghuni' => $penghuni->id_penghuni,
                'id_teman' => $temanId,
                'id_kamar' => $kamar->id_kamar,
                'id_paket_kamar' => $paket->id_paket_kamar,
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
                'total_durasi' => $paket->jenis_paket,
                'status_booking' => 'Pending', // Changed to Pending until payment
            ]);

            // Create payment record
            $pembayaran = Pembayaran::create([
                'id_user' => $user->id,
                'id_booking' => $booking->id_booking,
                'id_kamar' => $kamar->id_kamar,
                'tanggal_pembayaran' => now(),
                'status_pembayaran' => 'Belum bayar',
                'jumlah_pembayaran' => $paket->harga,
                'payment_type' => 'Booking',
            ]);

            // Update room status to Dipesan (Reserved)
            $kamar->update(['status' => 'Dipesan']);

            DB::commit();

            // Flash success message
            session()->flash('success', 'Booking berhasil dibuat! Silakan lanjutkan ke pembayaran.');

            // Redirect to payment
            return redirect()->route('payment.form', ['pembayaran' => $pembayaran->id_pembayaran]);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // Payment Methods - To be implemented in Phase 5
    public function createPayment(Pembayaran $pembayaran)
    {
        // Validate user owns this payment
        if ($pembayaran->id_user !== Auth::id()) {
            abort(403, 'Unauthorized access to payment.');
        }

        // Load related data
        $pembayaran->load(['booking.kamar.tipeKamar', 'booking.paketKamar']);

        // TODO: Generate Midtrans payment token
        // This will be implemented in Phase 5 with Midtrans integration
        
        return view('user.payment.create', compact('pembayaran'));
    }

    public function processPayment(Request $request)
    {
        // TODO: Process payment with Midtrans
        // This will be implemented in Phase 5
        return redirect()->route('user.payment.success')->with('info', 'Payment processing akan diimplementasikan di Phase 5');
    }

    public function paymentSuccess(Request $request)
    {
        // TODO: Handle successful payment callback from Midtrans
        // Update payment status, booking status, room status
        // Send confirmation email
        // This will be implemented in Phase 5
        
        return view('user.payment.success');
    }

    public function paymentFailed(Request $request)
    {
        // TODO: Handle failed payment
        // Update payment status, potentially cancel booking
        // This will be implemented in Phase 5
        
        return view('user.payment.failed');
    }
}