@extends('layouts.app')

@section('title', 'Manage Bookings - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold gradient-text mb-2">Manage Bookings</h1>
            <p class="text-gray-600">View and manage all bookings</p>
        </div>
        <a href="{{ route('admin.bookings.create') }}" class="btn-primary text-white px-6 py-3 rounded-full font-medium">
            <i class="fas fa-plus mr-2"></i>Create Booking
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">{{ session('success') }}</div>
    @endif

    <div class="glass-effect rounded-2xl p-6 shadow-lg">
        <form method="GET" class="mb-6 flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by customer..." class="px-4 py-2 rounded-xl border-2 border-gray-200">
            <select name="status" class="px-4 py-2 rounded-xl border-2 border-gray-200">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="btn-primary text-white px-6 py-2 rounded-full">Filter</button>
        </form>

        @if($bookings->isEmpty())
            <div class="text-center py-12">
                <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-400 mb-2">No bookings yet</h3>
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
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-4 px-4">{{ $booking->user->name }}<br><span class="text-sm text-gray-500">{{ $booking->user->email }}</span></td>
                                <td class="py-4 px-4">{{ $booking->service->name }}</td>
                                <td class="py-4 px-4">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y H:i') }}</td>
                                <td class="py-4 px-4">
                                    @php
                                        $colors = ['pending' => 'yellow', 'confirmed' => 'green', 'completed' => 'gray', 'cancelled' => 'red'];
                                        $color = $colors[$booking->status] ?? 'gray';
                                    @endphp
                                    <span class="px-3 py-1 bg-{{ $color }}-100 text-{{ $color }}-700 rounded-full text-sm">{{ ucfirst($booking->status) }}</span>
                                </td>
                                <td class="py-4 px-4">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                <td class="py-4 px-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.bookings.show', $booking) }}" class="text-blue-600"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('admin.bookings.edit', $booking) }}" class="text-yellow-600"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $bookings->links() }}</div>
        @endif
    </div>
</div>
@endsection

