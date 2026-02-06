<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['booking.user', 'booking.service']);

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search')) {
            $query->where('xendit_invoice_id', 'like', '%' . $request->search . '%')
                  ->orWhereHas('booking.user', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%');
                  });
        }

        $payments = $query->latest()->paginate(15);
        
        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $payment->load(['booking.user', 'booking.service', 'booking.therapist']);
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Update payment status manually
     */
    public function updateStatus(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,expired,failed',
        ]);

        $payment->update([
            'status' => $validated['status'],
            'paid_at' => $validated['status'] === 'paid' ? now() : $payment->paid_at,
        ]);

        // Sync Booking Status
        if ($validated['status'] === 'paid') {
            $payment->booking->update(['status' => 'confirmed']);
        } elseif (in_array($validated['status'], ['expired', 'failed'])) {
            $payment->booking->update(['status' => 'cancelled']);
        }

        return redirect()->route('admin.payments.show', $payment)
            ->with('success', 'Payment status updated successfully.');
    }
}
