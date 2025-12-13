<?php

namespace App\Http\Controllers;

use App\Services\XenditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class XenditWebhookController extends Controller
{
    protected $xenditService;

    public function __construct(XenditService $xenditService)
    {
        $this->xenditService = $xenditService;
    }

    /**
     * Handle webhook dari Xendit
     */
    public function handle(Request $request)
    {
        // Log webhook for debugging
        Log::info('Xendit Webhook Received', $request->all());

        // Validasi callback token (optional tapi direkomendasikan)
        $callbackToken = $request->header('X-CALLBACK-TOKEN');
        $expectedToken = config('services.xendit.callback_token');

        if ($callbackToken !== $expectedToken) {
            Log::warning('Invalid Xendit webhook token');
            return response()->json(['error' => 'Invalid token'], 401);
        }

        // Process webhook
        $result = $this->xenditService->handleWebhook($request->all());

        if ($result) {
            return response()->json(['success' => true], 200);
        }

        return response()->json(['error' => 'Failed to process webhook'], 500);
    }
}
