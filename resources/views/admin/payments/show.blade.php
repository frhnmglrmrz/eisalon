@extends('layouts.app')

@section('title', 'View Payment - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8 flex justify-between items-center">
        <h1 class="text-4xl font-bold gradient-text mb-2">Payment Details</h1>
        <a href="{{ route('admin.payments.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-full font-medium">Back</a>
    </div>

    <div class="glass-effect rounded-2xl p-8 shadow-lg">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h2 class="text-xl font-bold mb-4">Payment Info</h2>
                <p><strong>Invoice ID:</strong> {{ $payment->xendit_invoice_id }}</p>
                <p><strong>Amount:</strong> Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                <p><strong>Status:</strong> <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">{{ ucfirst($payment->status) }}</span></p>
                @if($payment->payment_method)
                    <p><strong>Payment Method:</strong> {{ $payment->payment_method }}</p>
                @endif
                @if($payment->paid_at)
                    <p><strong>Paid At:</strong> {{ $payment->paid_at->format('d M Y H:i') }}</p>
                @endif
            </div>
            <div>
                <h2 class="text-xl font-bold mb-4">Booking Info</h2>
                <p><strong>Customer:</strong> {{ $payment->booking->user->name }}</p>
                <p><strong>Service:</strong> {{ $payment->booking->service->name }}</p>
                <p><strong>Booking Date:</strong> {{ \Carbon\Carbon::parse($payment->booking->booking_date)->format('d M Y H:i') }}</p>
            </div>
        </div>
        @if($payment->xendit_invoice_url)
            <div class="mt-6">
                <a href="{{ $payment->xendit_invoice_url }}" target="_blank" class="btn-primary text-white px-6 py-3 rounded-full font-medium">
                    <i class="fas fa-external-link-alt mr-2"></i>View Invoice
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

