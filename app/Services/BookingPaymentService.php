<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Pembayaran;
use App\Models\User;
use App\Models\Penghuni;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BookingPaymentService
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Process booking payment
     *
     * @param Booking $booking
     * @return array
     * @throws Exception
     */
    public function processBookingPayment(Booking $booking)
    {
        try {
            DB::beginTransaction();

            // Verify booking is valid for payment
            $this->validateBooking($booking);

            // Create or update penghuni record
            $penghuni = $this->createOrUpdatePenghuni($booking->penghuni->user);

            // Create payment record
            $payment = $this->createPaymentRecord($booking);

            // Generate payment URL via Midtrans
            $paymentData = $this->preparePaymentData($booking, $payment);
            $paymentUrl = $this->midtransService->createPayment($paymentData);

            // Update booking status
            $booking->status_booking = 'Dipesan';
            $booking->save();

            // Update kamar status
            $booking->kamar->status = 'Dipesan';
            $booking->kamar->save();

            DB::commit();

            // Send confirmation email (async)
            $this->sendBookingConfirmationEmail($booking, $payment);

            return [
                'success' => true,
                'payment_url' => $paymentUrl,
                'payment' => $payment
            ];

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Booking payment processing failed: ' . $e->getMessage());
            throw new Exception('Failed to process booking payment: ' . $e->getMessage());
        }
    }

    /**
     * Validate booking for payment
     *
     * @param Booking $booking
     * @throws Exception
     */
    protected function validateBooking(Booking $booking)
    {
        // Check if room is still available
        if ($booking->kamar->status !== 'Kosong') {
            throw new Exception('Kamar sudah tidak tersedia.');
        }

        // Check if booking dates are valid
        if ($booking->tanggal_mulai <= now()) {
            throw new Exception('Tanggal mulai booking tidak valid.');
        }

        // Check for conflicting bookings
        $conflictingBooking = Booking::where('id_kamar', $booking->id_kamar)
            ->where('status_booking', '!=', 'Dibatalkan')
            ->where(function ($query) use ($booking) {
                $query->whereBetween('tanggal_mulai', [$booking->tanggal_mulai, $booking->tanggal_selesai])
                    ->orWhereBetween('tanggal_selesai', [$booking->tanggal_mulai, $booking->tanggal_selesai]);
            })
            ->first();

        if ($conflictingBooking) {
            throw new Exception('Terdapat booking lain pada periode yang sama.');
        }
    }

    /**
     * Create or update penghuni record
     *
     * @param User $user
     * @return Penghuni
     */
    protected function createOrUpdatePenghuni(User $user)
    {
        $penghuni = Penghuni::firstOrNew(['id_user' => $user->id]);
        $penghuni->status_penghuni = 'Aktif';
        $penghuni->save();

        return $penghuni;
    }

    /**
     * Create payment record
     *
     * @param Booking $booking
     * @return Pembayaran
     */
    protected function createPaymentRecord(Booking $booking)
    {
        $orderId = 'MYKOST-' . time() . '-' . $booking->id_booking;

        $payment = new Pembayaran();
        $payment->id_user = $booking->penghuni->user->id;
        $payment->id_booking = $booking->id_booking;
        $payment->id_kamar = $booking->id_kamar;
        $payment->tanggal_pembayaran = now();
        $payment->status_pembayaran = 'Belum bayar';
        $payment->jumlah_pembayaran = $booking->paketKamar->harga;
        $payment->payment_type = 'Booking';
        $payment->midtrans_order_id = $orderId;
        $payment->save();

        return $payment;
    }

    /**
     * Prepare payment data for Midtrans
     *
     * @param Booking $booking
     * @param Pembayaran $payment
     * @return array
     */
    protected function preparePaymentData(Booking $booking, Pembayaran $payment)
    {
        $user = $booking->penghuni->user;

        return [
            'order_id' => $payment->midtrans_order_id,
            'gross_amount' => $payment->jumlah_pembayaran,
            'customer_name' => $user->nama,
            'customer_email' => $user->email,
            'customer_phone' => $user->no_hp,
            'items' => [[
                'id' => $booking->kamar->id_kamar,
                'price' => $payment->jumlah_pembayaran,
                'quantity' => 1,
                'name' => "Kamar {$booking->kamar->no_kamar} ({$booking->paketKamar->jenis_paket})"
            ]]
        ];
    }

    /**
     * Send booking confirmation email
     *
     * @param Booking $booking
     * @param Pembayaran $payment
     */
    protected function sendBookingConfirmationEmail(Booking $booking, Pembayaran $payment)
    {
        try {
            // Note: Email implementation will be done in Phase 9
            // For now, we just log the intent
            Log::info('Booking confirmation email would be sent to: ' . $booking->penghuni->user->email);
        } catch (Exception $e) {
            Log::error('Failed to send booking confirmation email: ' . $e->getMessage());
        }
    }

    /**
     * Validate payment status
     *
     * @param Pembayaran $payment
     * @return bool
     */
    public function validatePaymentStatus(Pembayaran $payment)
    {
        // Check payment expiration (24 hours)
        if ($payment->created_at->addHours(24) < now() && $payment->status_pembayaran === 'Belum bayar') {
            $payment->status_pembayaran = 'Gagal';
            $payment->save();

            // Cancel booking
            $booking = $payment->booking;
            $booking->status_booking = 'Dibatalkan';
            $booking->save();

            // Update room status
            $kamar = $booking->kamar;
            $kamar->status = 'Kosong';
            $kamar->save();

            return false;
        }

        return true;
    }
} 