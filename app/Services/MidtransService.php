<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Exception;

class MidtransService
{
    public function __construct()
    {
        // Set your Merchant Server Key
        Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = config('midtrans.is_production');
        // Set sanitization on (default)
        Config::$isSanitized = config('midtrans.is_sanitized');
        // Set 3DS transaction for credit card to true
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Create Midtrans Payment URL
     *
     * @param array $params Payment parameters
     * @return string Payment URL
     * @throws Exception
     */
    public function createPayment(array $params)
    {
        try {
            $transaction_details = [
                'order_id' => $params['order_id'],
                'gross_amount' => $params['gross_amount'],
            ];

            $item_details = [];
            if (isset($params['items'])) {
                $item_details = $params['items'];
            }

            $customer_details = [
                'first_name' => $params['customer_name'] ?? '',
                'email' => $params['customer_email'] ?? '',
                'phone' => $params['customer_phone'] ?? '',
            ];

            // URL kembali setelah pembayaran
            $finish_url = route('payment.success', ['orderId' => $params['order_id']]);
            $error_url = route('payment.failed', ['orderId' => $params['order_id']]);
            
            $callbacks = [
                'finish' => $finish_url,
                'error' => $error_url,
            ];

            $transaction_data = [
                'transaction_details' => $transaction_details,
                'item_details' => $item_details,
                'customer_details' => $customer_details,
                'callbacks' => $callbacks
            ];

            // Create payment URL
            $paymentUrl = Snap::createTransaction($transaction_data)->redirect_url;

            return $paymentUrl;
        } catch (Exception $e) {
            throw new Exception('Error creating Midtrans payment: ' . $e->getMessage());
        }
    }

    /**
     * Handle payment notification from Midtrans
     *
     * @param array $notification Notification data
     * @return array Processed notification data
     */
    public function handleNotification(array $notification)
    {
        $transaction_status = $notification['transaction_status'];
        $fraud_status = $notification['fraud_status'] ?? null;

        $status = [
            'success' => false,
            'message' => 'Payment failed',
            'data' => $notification
        ];

        if ($transaction_status == 'capture') {
            if ($fraud_status == 'challenge') {
                $status['message'] = 'Payment challenge';
            } else if ($fraud_status == 'accept') {
                $status['success'] = true;
                $status['message'] = 'Payment success';
            }
        } else if ($transaction_status == 'settlement') {
            $status['success'] = true;
            $status['message'] = 'Payment success';
        } else if ($transaction_status == 'pending') {
            $status['message'] = 'Payment pending';
        } else if ($transaction_status == 'deny') {
            $status['message'] = 'Payment denied';
        } else if ($transaction_status == 'expire') {
            $status['message'] = 'Payment expired';
        } else if ($transaction_status == 'cancel') {
            $status['message'] = 'Payment cancelled';
        }

        return $status;
    }
} 