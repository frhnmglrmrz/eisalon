@extends('layouts.app')

@section('title', 'Edit Booking - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8">
        <h1 class="text-4xl font-bold gradient-text mb-2">Edit Booking</h1>
    </div>

    <div class="glass-effect rounded-2xl p-8 shadow-lg max-w-3xl">
        <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
            @csrf @method('PUT')
            <div class="space-y-6">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Customer *</label>
                    <select name="user_id" required class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $booking->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Service *</label>
                    <select name="service_id" required class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none">
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ $booking->service_id == $service->id ? 'selected' : '' }}>{{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Therapist</label>
                    <select name="therapist_id" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none">
                        <option value="">Select Therapist</option>
                        @foreach($therapists as $therapist)
                            <option value="{{ $therapist->id }}" {{ $booking->therapist_id == $therapist->id ? 'selected' : '' }}>{{ $therapist->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Booking Date & Time *</label>
                    <input type="datetime-local" name="booking_date" value="{{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d\TH:i') }}" required class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Status *</label>
                    <select name="status" required class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none">
                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="in_progress" {{ $booking->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Total Price *</label>
                    <input type="number" name="total_price" value="{{ $booking->total_price }}" step="0.01" min="0" required class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Notes</label>
                    <textarea name="notes" rows="3" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none">{{ $booking->notes }}</textarea>
                </div>
            </div>
            <div class="mt-8 flex space-x-4">
                <button type="submit" class="btn-primary text-white px-8 py-3 rounded-full font-medium">Update</button>
                <a href="{{ route('admin.bookings.index') }}" class="bg-gray-200 text-gray-700 px-8 py-3 rounded-full font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

