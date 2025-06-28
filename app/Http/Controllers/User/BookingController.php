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
            'id_teman' => 'nullable|exists:users,id',
        ]);

        DB::beginTransaction();

        try {
            $user = Auth::user();
            $kamar = Kamar::findOrFail($request->id_kamar);
            $paket = PaketKamar::findOrFail($request->id_paket_kamar);

            // Check room availability
            if ($kamar->status !== 'Kosong') {
                throw new \Exception('Kamar tidak tersedia.');
            }

            // Create or get penghuni record
            $penghuni = Penghuni::firstOrCreate(
                ['id_user' => $user->id],
                ['status_penghuni' => 'Aktif']
            );

            // Calculate end date based on package
            $tanggalMulai = \Carbon\Carbon::parse($request->tanggal_mulai);
            $tanggalSelesai = match($paket->jenis_paket) {
                'Mingguan' => $tanggalMulai->copy()->addWeek(),
                'Bulanan' => $tanggalMulai->copy()->addMonth(),
                'Tahunan' => $tanggalMulai->copy()->addYear(),
            };

            // Handle friend booking
            $temanId = null;
            if ($request->filled('id_teman')) {
                $teman = User::findOrFail($request->id_teman);
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
                'status_booking' => 'Aktif',
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

            // Update room status
            $kamar->update(['status' => 'Dipesan']);

            DB::commit();

            // Redirect to payment
            return redirect()->route('user.payment.create', ['pembayaran' => $pembayaran->id_pembayaran]);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
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