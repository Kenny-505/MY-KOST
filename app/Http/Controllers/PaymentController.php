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
     * Show payment form
     *
     * @param Booking $booking
     * @return \Illuminate\Http\Response
     */
    public function showPaymentForm(Booking $booking)
    {
        // Get the current user and their penghuni record
        $user = auth()->user();
        $penghuni = $user->activePenghuni();
        
        if (!$penghuni) {
            abort(403, 'Unauthorized access to booking.');
        }
        
        // Validate user is involved in this booking (either as primary or secondary tenant)
        if ($booking->id_penghuni !== $penghuni->id_penghuni && 
            $booking->id_teman !== $penghuni->id_penghuni) {
            abort(403, 'Unauthorized access to booking.');
        }

        // Load related data
        $booking->load(['kamar.tipeKamar', 'paketKamar', 'penghuni.user']);
        
        if ($booking->id_teman) {
            $booking->load(['teman.user']);
        }

        // Get or create payment record for this booking (latest payment)
        $payment = Pembayaran::where('id_booking', $booking->id_booking)
                             ->orderBy('id_pembayaran', 'desc')
                             ->first();

        if (!$payment) {
            // Create new payment record
            $payment = new Pembayaran();
            $payment->id_user = auth()->id();
            $payment->id_booking = $booking->id_booking;
            $payment->id_kamar = $booking->id_kamar;
            $payment->tanggal_pembayaran = now();
            $payment->status_pembayaran = 'Belum bayar';
            $payment->jumlah_pembayaran = $booking->paketKamar->harga;
            $payment->payment_type = 'Booking';
            $payment->save();
        }

        return view('payment.form', compact('booking', 'payment'));
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
            // Jika request adalah JSON, ambil data dari JSON
            $data = $request->isJson() ? $request->json()->all() : $request->all();
            
            $validator = \Illuminate\Support\Facades\Validator::make($data, [
                'booking_id' => 'required|exists:booking,id_booking',
                'payment_type' => 'required|in:Booking,Extension,Additional',
                'payment_method' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false, 
                    'message' => $validator->errors()->first()
                ], 422);
            }

            $booking = Booking::with(['penghuni.user', 'teman.user', 'kamar', 'paketKamar'])->findOrFail($data['booking_id']);
            
            // Get the current user and their penghuni record
            $currentUser = auth()->user();
            $currentPenghuni = $currentUser->activePenghuni();
            
            if (!$currentPenghuni) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Unauthorized. User does not have active penghuni status.'
                ], 403);
            }
            
            // Check if current user is authorized to make payment for this booking
            if ($booking->id_penghuni !== $currentPenghuni->id_penghuni && 
                $booking->id_teman !== $currentPenghuni->id_penghuni) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Unauthorized. You are not associated with this booking.'
                ], 403);
            }

            // Generate unique order ID
            $orderId = 'MYKOST-' . time() . '-' . $booking->id_booking;

            // Prepare payment parameters using the current user's information
            $params = [
                'order_id' => $orderId,
                'gross_amount' => (int)$booking->paketKamar->harga,
                'customer_name' => $currentUser->nama,
                'customer_email' => $currentUser->email,
                'customer_phone' => $currentUser->no_hp,
                'items' => [[
                    'id' => $booking->kamar->id_kamar,
                    'price' => (int)$booking->paketKamar->harga,
                    'quantity' => 1,
                    'name' => "Kamar {$booking->kamar->no_kamar} ({$booking->paketKamar->jenis_paket})"
                ]]
            ];

            // Create payment record
            $payment = Pembayaran::where('id_booking', $booking->id_booking)
                                  ->where('status_pembayaran', 'Belum bayar')
                                  ->orderBy('id_pembayaran', 'desc')
                                  ->first();
            
            if (!$payment) {
                $payment = new Pembayaran();
                $payment->id_user = $currentUser->id; // Use the current user's ID
                $payment->id_booking = $booking->id_booking;
                $payment->id_kamar = $booking->id_kamar;
                $payment->tanggal_pembayaran = now();
                $payment->status_pembayaran = 'Belum bayar';
                $payment->jumlah_pembayaran = $booking->paketKamar->harga;
                $payment->payment_type = $data['payment_type'];
            }
            
            $payment->midtrans_order_id = $orderId;
            $payment->save();

            // Get payment URL from Midtrans
            $paymentUrl = $this->midtransService->createPayment($params);

            // Return success response
            return response()->json([
                'success' => true,
                'payment_url' => $paymentUrl,
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
        try {
            $payment = Pembayaran::with(['booking.penghuni.user', 'booking.kamar', 'booking.paketKamar'])
                ->where('midtrans_order_id', $orderId)
                ->firstOrFail();
            
            // Jika status pembayaran belum diubah oleh callback, ubah manual
            if ($payment->status_pembayaran === 'Belum bayar') {
                DB::beginTransaction();
                $payment->status_pembayaran = 'Lunas';
                $payment->save();
                
                // Update related records
                $this->handleBookingPayment($payment);
                DB::commit();
            }
            
            // Login pengguna secara otomatis jika belum login
            if (!auth()->check()) {
                auth()->login($payment->booking->penghuni->user);
            }
            
            return view('payment.success', [
                'payment' => $payment,
                'booking' => $payment->booking
            ]);
        } catch (\Exception $e) {
            Log::error('Error showing payment success: '.$e->getMessage());
            return redirect()->route('welcome')->with('error', 'Terjadi kesalahan saat menampilkan halaman sukses. Silakan periksa status pembayaran Anda di dashboard.');
        }
    }

    /**
     * Display payment failed page
     *
     * @param string $orderId
     * @return \Illuminate\Http\Response
     */
    public function paymentFailed(string $orderId)
    {
        try {
            $payment = Pembayaran::with(['booking.penghuni.user', 'booking.kamar', 'booking.paketKamar'])
                ->where('midtrans_order_id', $orderId)
                ->firstOrFail();
            
            // Jika status pembayaran belum diubah, ubah ke gagal
            if ($payment->status_pembayaran === 'Belum bayar') {
                $payment->status_pembayaran = 'Gagal';
                $payment->save();
            }
            
            // Login pengguna secara otomatis jika belum login
            if (!auth()->check()) {
                auth()->login($payment->booking->penghuni->user);
            }
            
            return view('payment.failed', [
                'payment' => $payment,
                'booking' => $payment->booking
            ]);
        } catch (\Exception $e) {
            Log::error('Error showing payment failed: '.$e->getMessage());
            return redirect()->route('welcome')->with('error', 'Terjadi kesalahan saat menampilkan halaman gagal. Silakan periksa status pembayaran Anda di dashboard.');
        }
    }

    /**
     * Check payment status
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkStatus(Request $request)
    {
        try {
            $orderId = $request->query('order_id');
            
            if (!$orderId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order ID is required'
                ], 400);
            }
            
            $payment = Pembayaran::where('midtrans_order_id', $orderId)->first();
            
            if (!$payment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment not found'
                ], 404);
            }
            
            // Redirect based on payment status
            if ($payment->status_pembayaran === 'Lunas') {
                return response()->json([
                    'success' => true,
                    'redirect' => route('payment.success', $orderId)
                ]);
            } else if ($payment->status_pembayaran === 'Gagal') {
                return response()->json([
                    'success' => false,
                    'redirect' => route('payment.failed', $orderId)
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment is still pending',
                    'status' => $payment->status_pembayaran
                ]);
            }
        } catch (Exception $e) {
            Log::error('Payment status check failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to check payment status: ' . $e->getMessage()
            ], 500);
        }
    }
} 