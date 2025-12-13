<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class XenditService
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.xendit.secret_key');
        $this->baseUrl = config('services.xendit.base_url', 'https://api.xendit.co');
    }

    /**
     * Buat invoice Xendit untuk booking
     */
    public function createInvoice(Booking $booking)
    {
        try {
            $externalId = 'booking-' . $booking->id . '-' . time();
            
            $payload = [
                'external_id' => $externalId,
                'amount' => (float) $booking->total_price,
                'payer_email' => $booking->user->email,
                'description' => 'Payment for ' . $booking->service->name,
                'invoice_duration' => 86400, // 24 jam
                'success_redirect_url' => route('booking.success', $booking->id),
                'failure_redirect_url' => route('booking.failed', $booking->id),
                'currency' => 'IDR',
                'items' => [
                    [
                        'name' => $booking->service->name,
                        'quantity' => 1,
                        'price' => (float) $booking->total_price,
                    ]
                ],
            ];

            $response = Http::withBasicAuth($this->apiKey, '')
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl . '/v2/invoices', $payload);

            if ($response->successful()) {
                $data = $response->json();
                
                // Simpan payment record
                $payment = Payment::create([
                    'booking_id' => $booking->id,
                    'xendit_invoice_id' => $data['id'],
                    'xendit_invoice_url' => $data['invoice_url'],
                    'amount' => $booking->total_price,
                    'status' => 'pending',
                    'xendit_response' => $data,
                ]);

                return [
                    'success' => true,
                    'payment' => $payment,
                    'invoice_url' => $data['invoice_url'],
                ];
            }

            Log::error('Xendit Invoice Creation Failed', [
                'response' => $response->json(),
                'status' => $response->status(),
            ]);

            return [
                'success' => false,
                'message' => 'Failed to create payment invoice',
            ];

        } catch (\Exception $e) {
            Log::error('Xendit Service Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Handle webhook dari Xendit
     */
    public function handleWebhook($payload)
    {
        try {
            // Validasi webhook signature (optional tapi direkomendasikan)
            $callbackToken = config('services.xendit.callback_token');
            
            $invoiceId = $payload['id'];
            $status = $payload['status'];

            $payment = Payment::where('xendit_invoice_id', $invoiceId)->first();

            if (!$payment) {
                Log::warning('Payment not found for webhook', ['invoice_id' => $invoiceId]);
                return false;
            }

            // Update payment status berdasarkan webhook
            switch ($status) {
                case 'PAID':
                case 'SETTLED':
                    $payment->markAsPaid($payload['payment_method'] ?? null);
                    $payment->booking->update(['status' => 'confirmed']);

                    // Notify User
                    $payment->booking->user->notify(new \App\Notifications\PaymentConfirmed($payment->booking));

                    // Notify Admin
                    $admin = \App\Models\User::where('email', 'admin@eisalon.com')->first();
                    if ($admin) {
                        $admin->notify(new \App\Notifications\NewPaymentReceived($payment->booking));
                    }
                    break;

                case 'EXPIRED':
                    $payment->markAsExpired();
                    $payment->booking->update(['status' => 'cancelled']);
                    break;

                case 'FAILED':
                    $payment->markAsFailed();
                    break;
            }

            // Update xendit response
            $payment->update([
                'xendit_response' => $payload,
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Xendit Webhook Error', [
                'message' => $e->getMessage(),
                'payload' => $payload,
            ]);

            return false;
        }
    }

    /**
     * Cek status payment dari Xendit
     */
    public function checkInvoiceStatus($invoiceId)
    {
        try {
            $response = Http::withBasicAuth($this->apiKey, '')
                ->get($this->baseUrl . '/v2/invoices/' . $invoiceId);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to get invoice status',
            ];

        } catch (\Exception $e) {
            Log::error('Xendit Check Status Error', [
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Expire invoice secara manual
     */
    public function expireInvoice($invoiceId)
    {
        try {
            $response = Http::withBasicAuth($this->apiKey, '')
                ->post($this->baseUrl . '/v2/invoices/' . $invoiceId . '/expire!');

            return $response->successful();

        } catch (\Exception $e) {
            Log::error('Xendit Expire Invoice Error', [
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
