<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Pembayaran;
use App\Models\User;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Exception;

class PaymentController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Create a new payment transaction
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createPayment(Request $request)
    {
        try {
            $request->validate([
                'booking_id' => 'required|exists:booking,id_booking',
                'payment_type' => 'required|in:Booking,Extension,Additional'
            ]);

            $booking = Booking::with(['penghuni.user', 'kamar', 'paketKamar'])->findOrFail($request->booking_id);
            $user = $booking->penghuni->user;

            // Generate unique order ID
            $orderId = 'MYKOST-' . time() . '-' . $booking->id_booking;

            // Prepare payment parameters
            $params = [
                'order_id' => $orderId,
                'gross_amount' => $booking->paketKamar->harga,
                'customer_name' => $user->nama,
                'customer_email' => $user->email,
                'customer_phone' => $user->no_hp,
                'items' => [[
                    'id' => $booking->kamar->id_kamar,
                    'price' => $booking->paketKamar->harga,
                    'quantity' => 1,
                    'name' => "Kamar {$booking->kamar->no_kamar} ({$booking->paketKamar->jenis_paket})"
                ]]
            ];

            // Create payment record
            $payment = new Pembayaran();
            $payment->id_user = $user->id;
            $payment->id_booking = $booking->id_booking;
            $payment->id_kamar = $booking->id_kamar;
            $payment->tanggal_pembayaran = now();
            $payment->status_pembayaran = 'Belum bayar';
            $payment->jumlah_pembayaran = $booking->paketKamar->harga;
            $payment->payment_type = $request->payment_type;
            $payment->midtrans_order_id = $orderId;
            $payment->save();

            // Get payment URL from Midtrans
            $paymentUrl = $this->midtransService->createPayment($params);

            // Generate QR Code
            $qrCode = base64_encode(QrCode::format('png')
                ->size(300)
                ->errorCorrection('H')
                ->generate($paymentUrl));

            return response()->json([
                'success' => true,
                'payment_url' => $paymentUrl,
                'qr_code' => $qrCode,
                'order_id' => $orderId
            ]);

        } catch (Exception $e) {
            Log::error('Payment creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create payment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle payment notification from Midtrans
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function handleCallback(Request $request)
    {
        try {
            $notification = $request->all();
            
            // Process the notification
            $status = $this->midtransService->handleNotification($notification);
            
            // Find the payment
            $payment = Pembayaran::where('midtrans_order_id', $notification['order_id'])->firstOrFail();
            
            DB::beginTransaction();
            
            // Update payment status
            if ($status['success']) {
                $payment->status_pembayaran = 'Lunas';
                $payment->midtrans_transaction_id = $notification['transaction_id'] ?? null;
                
                // Update related records based on payment type
                switch ($payment->payment_type) {
                    case 'Booking':
                        $this->handleBookingPayment($payment);
                        break;
                    case 'Extension':
                        $this->handleExtensionPayment($payment);
                        break;
                    case 'Additional':
                        $this->handleAdditionalPayment($payment);
                        break;
                }
            } else {
                $payment->status_pembayaran = 'Gagal';
            }
            
            $payment->save();
            DB::commit();

            return response()->json(['success' => true]);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Payment callback failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Handle successful booking payment
     *
     * @param Pembayaran $payment
     */
    protected function handleBookingPayment(Pembayaran $payment)
    {
        $booking = $payment->booking;
        $booking->status_booking = 'Aktif';
        $booking->save();

        $kamar = $booking->kamar;
        $kamar->status = 'Terisi';
        $kamar->save();

        // Create or update penghuni status
        $penghuni = $booking->penghuni;
        $penghuni->status_penghuni = 'Aktif';
        $penghuni->save();
    }

    /**
     * Handle successful extension payment
     *
     * @param Pembayaran $payment
     */
    protected function handleExtensionPayment(Pembayaran $payment)
    {
        $booking = $payment->booking;
        // Extension logic will be implemented in Phase 7
        // This is a placeholder for now
    }

    /**
     * Handle successful additional tenant payment
     *
     * @param Pembayaran $payment
     */
    protected function handleAdditionalPayment(Pembayaran $payment)
    {
        $booking = $payment->booking;
        // Additional tenant logic will be implemented in Phase 7
        // This is a placeholder for now
    }

    /**
     * Display payment success page
     *
     * @param string $orderId
     * @return \Illuminate\Http\Response
     */
    public function paymentSuccess(string $orderId)
    {
        $payment = Pembayaran::where('midtrans_order_id', $orderId)->firstOrFail();
        
        return view('payment.success', [
            'payment' => $payment,
            'booking' => $payment->booking
        ]);
    }

    /**
     * Display payment failed page
     *
     * @param string $orderId
     * @return \Illuminate\Http\Response
     */
    public function paymentFailed(string $orderId)
    {
        $payment = Pembayaran::where('midtrans_order_id', $orderId)->firstOrFail();
        
        return view('payment.failed', [
            'payment' => $payment,
            'booking' => $payment->booking
        ]);
    }
} 