@extends('layouts.app')

@section('title', 'Admin Dashboard - Ei Salon')

@section('content')
<div class="container mx-auto px-6 py-12">
    <!-- Header -->
    <div class="mb-12 animate-fadeIn">
        <h1 class="text-4xl font-bold gradient-text mb-4">Admin Dashboard</h1>
        <p class="text-gray-600">Welcome back, {{ auth()->user()->name }}! Manage your salon operations</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <!-- Total Users -->
        <div class="glass-effect rounded-2xl p-6 shadow-lg animate-fadeIn">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Total Users</p>
                    <h3 class="text-3xl font-bold gradient-text">{{ $stats['total_users'] }}</h3>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Bookings -->
        <div class="glass-effect rounded-2xl p-6 shadow-lg animate-fadeIn" style="animation-delay: 0.1s;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Total Bookings</p>
                    <h3 class="text-3xl font-bold gradient-text">{{ $stats['total_bookings'] }}</h3>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-pink-400 to-pink-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-calendar-check text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Services -->
        <div class="glass-effect rounded-2xl p-6 shadow-lg animate-fadeIn" style="animation-delay: 0.2s;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Total Services</p>
                    <h3 class="text-3xl font-bold gradient-text">{{ $stats['total_services'] }}</h3>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-spa text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="glass-effect rounded-2xl p-6 shadow-lg animate-fadeIn" style="animation-delay: 0.3s;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Total Revenue</p>
                    <h3 class="text-3xl font-bold gradient-text">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-white text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <!-- Pending Bookings -->
        <div class="glass-effect rounded-2xl p-6 shadow-lg animate-fadeIn">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800">Pending</h3>
                <span class="bg-yellow-500 text-white px-4 py-2 rounded-full text-sm font-medium">
                    {{ $stats['pending_bookings'] }}
                </span>
            </div>
            <p class="text-gray-600 text-sm">Bookings awaiting confirmation</p>
        </div>

        <!-- Confirmed Bookings -->
        <div class="glass-effect rounded-2xl p-6 shadow-lg animate-fadeIn" style="animation-delay: 0.1s;">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800">Confirmed</h3>
                <span class="bg-green-500 text-white px-4 py-2 rounded-full text-sm font-medium">
                    {{ $stats['confirmed_bookings'] }}
                </span>
            </div>
            <p class="text-gray-600 text-sm">Confirmed appointments</p>
        </div>

        <!-- Completed Bookings -->
        <div class="glass-effect rounded-2xl p-6 shadow-lg animate-fadeIn" style="animation-delay: 0.2s;">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800">Completed</h3>
                <span class="bg-gray-500 text-white px-4 py-2 rounded-full text-sm font-medium">
                    {{ $stats['completed_bookings'] }}
                </span>
            </div>
            <p class="text-gray-600 text-sm">Finished appointments</p>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="glass-effect rounded-2xl p-8 shadow-lg animate-fadeIn">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold gradient-text">Recent Bookings</h2>
            <span class="text-gray-600 text-sm">{{ $stats['total_reviews'] }} Total Reviews</span>
        </div>

        @if($recent_bookings->isEmpty())
            <div class="text-center py-12">
                <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-400 mb-2">No bookings yet</h3>
                <p class="text-gray-500">Bookings will appear here once customers make appointments</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Customer</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Service</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Date & Time</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Status</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recent_bookings as $booking)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="py-4 px-4">
                                    <div class="font-medium text-gray-800">{{ $booking->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $booking->user->email }}</div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="font-medium text-gray-800">{{ $booking->service->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $booking->service->category }}</div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($booking->booking_date)->format('H:i') }}</div>
                                </td>
                                <td class="py-4 px-4">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-500',
                                            'confirmed' => 'bg-green-500',
                                            'in_progress' => 'bg-blue-500',
                                            'completed' => 'bg-gray-500',
                                            'cancelled' => 'bg-red-500',
                                        ];
                                        $color = $statusColors[$booking->status] ?? 'bg-gray-500';
                                    @endphp
                                    <span class="{{ $color }} text-white px-3 py-1 rounded-full text-xs font-medium">
                                        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="font-medium text-gray-800">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection

