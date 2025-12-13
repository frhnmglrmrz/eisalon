@extends('layouts.app')

@section('title', 'Payment Failed - Ei Salon')

@section('content')
<div class="min-h-screen flex items-center justify-center px-6 py-12">
    <div class="max-w-md w-full glass-effect rounded-2xl shadow-2xl p-8 text-center animate-fadeIn">
        <!-- Error Icon -->
        <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-times-circle text-red-500 text-5xl"></i>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Payment Failed</h1>
        <p class="text-gray-600 mb-8">
            Unfortunately, your payment could not be processed. Please try again or contact our support team.
        </p>
        
        <!-- Booking Details -->
        <div class="bg-red-50 rounded-xl p-6 mb-8 text-left">
            <h3 class="font-bold text-gray-800 mb-4">Booking Information</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Service:</span>
                    <span class="font-bold text-gray-800">{{ $booking->service->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Date & Time:</span>
                    <span class="font-bold text-gray-800">{{ $booking->booking_date->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-medium">Pending Payment</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Amount:</span>
                    <span class="text-xl font-bold text-gray-800">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="space-y-3">
            @if($booking->payment)
                <a href="{{ $booking->payment->xendit_invoice_url }}" class="block w-full btn-primary text-white px-6 py-3 rounded-full font-medium">
                    <i class="fas fa-redo mr-2"></i>Try Payment Again
                </a>
            @endif
            <a href="{{ route('bookings.index') }}" class="block w-full bg-white border-2 border-pink-500 text-pink-500 px-6 py-3 rounded-full font-medium hover:bg-pink-50 transition">
                <i class="fas fa-list mr-2"></i>View My Bookings
            </a>
            <a href="{{ route('home') }}" class="block w-full text-gray-600 hover:text-pink-600 transition">
                <i class="fas fa-home mr-2"></i>Back to Home
            </a>
        </div>
    </div>
</div>
@endsection
