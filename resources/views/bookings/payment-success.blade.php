@extends('layouts.app')

@section('title', 'Payment Successful - Ei Salon')

@section('content')
<div class="min-h-screen flex items-center justify-center px-6 py-12">
    <div class="max-w-md w-full glass-effect rounded-2xl shadow-2xl p-8 text-center animate-fadeIn">
        <!-- Success Icon -->
        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-float">
            <i class="fas fa-check-circle text-green-500 text-5xl"></i>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Payment Successful!</h1>
        <p class="text-gray-600 mb-8">
            Your booking has been confirmed. We've sent a confirmation email to your registered email address.
        </p>
        
        <!-- Booking Details -->
        <div class="bg-gradient-to-br from-pink-50 to-orange-50 rounded-xl p-6 mb-8 text-left">
            <h3 class="font-bold text-gray-800 mb-4">Booking Details</h3>
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
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">Confirmed</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Paid:</span>
                    <span class="text-xl font-bold gradient-text">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="space-y-3">
            <a href="{{ route('bookings.show', $booking) }}" class="block w-full btn-primary text-white px-6 py-3 rounded-full font-medium">
                <i class="fas fa-eye mr-2"></i>View Booking Details
            </a>
            <a href="{{ route('home') }}" class="block w-full bg-white border-2 border-pink-500 text-pink-500 px-6 py-3 rounded-full font-medium hover:bg-pink-50 transition">
                <i class="fas fa-home mr-2"></i>Back to Home
            </a>
        </div>
    </div>
</div>
@endsection
