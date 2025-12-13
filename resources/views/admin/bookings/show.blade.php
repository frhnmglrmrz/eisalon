@extends('layouts.app')

@section('title', 'View Booking - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8 flex justify-between items-center">
        <h1 class="text-4xl font-bold gradient-text mb-2">Booking Details</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn-primary text-white px-6 py-3 rounded-full font-medium">Edit</a>
            <a href="{{ route('admin.bookings.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-full font-medium">Back</a>
        </div>
    </div>

    <div class="glass-effect rounded-2xl p-8 shadow-lg">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-xl font-bold mb-4">Customer</h2>
                <p><strong>Name:</strong> {{ $booking->user->name }}</p>
                <p><strong>Email:</strong> {{ $booking->user->email }}</p>
            </div>
            <div>
                <h2 class="text-xl font-bold mb-4">Service</h2>
                <p><strong>Service:</strong> {{ $booking->service->name }}</p>
                <p><strong>Category:</strong> {{ ucfirst($booking->service->category) }}</p>
            </div>
            <div>
                <h2 class="text-xl font-bold mb-4">Booking Info</h2>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y H:i') }}</p>
                <p><strong>Status:</strong> <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">{{ ucfirst($booking->status) }}</span></p>
                <p><strong>Amount:</strong> Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
            </div>
            @if($booking->therapist)
            <div>
                <h2 class="text-xl font-bold mb-4">Therapist</h2>
                <p><strong>Name:</strong> {{ $booking->therapist->name }}</p>
                <p><strong>Specialization:</strong> {{ ucfirst($booking->therapist->specialization) }}</p>
            </div>
            @endif
        </div>
        @if($booking->notes)
        <div class="mt-6">
            <h2 class="text-xl font-bold mb-2">Notes</h2>
            <p>{{ $booking->notes }}</p>
        </div>
        @endif
    </div>
</div>
@endsection

