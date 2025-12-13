@extends('layouts.app')

@section('title', 'View Service - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold gradient-text mb-2">{{ $service->name }}</h1>
            <p class="text-gray-600">Service details</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.services.edit', $service) }}" class="btn-primary text-white px-6 py-3 rounded-full font-medium">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('admin.services.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-full font-medium hover:bg-gray-300">
                Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="glass-effect rounded-2xl p-8 shadow-lg">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Service Information</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="text-gray-600 text-sm">Name</label>
                    <p class="text-gray-800 font-semibold text-lg">{{ $service->name }}</p>
                </div>
                
                <div>
                    <label class="text-gray-600 text-sm">Description</label>
                    <p class="text-gray-800">{{ $service->description }}</p>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-gray-600 text-sm">Price</label>
                        <p class="text-gray-800 font-semibold text-lg">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                    </div>
                    
                    <div>
                        <label class="text-gray-600 text-sm">Duration</label>
                        <p class="text-gray-800 font-semibold text-lg">{{ $service->duration }} minutes</p>
                    </div>
                </div>
                
                <div>
                    <label class="text-gray-600 text-sm">Category</label>
                    <p class="text-gray-800">
                        <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-medium">
                            {{ ucfirst($service->category) }}
                        </span>
                    </p>
                </div>
                
                <div>
                    <label class="text-gray-600 text-sm">Status</label>
                    <p class="text-gray-800">
                        @if($service->is_active)
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">Active</span>
                        @else
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">Inactive</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="glass-effect rounded-2xl p-8 shadow-lg">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Service Image</h2>
            @if($service->image)
                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full rounded-lg">
            @else
                <div class="w-full h-64 bg-gradient-to-br from-pink-400 to-orange-400 rounded-lg flex items-center justify-center">
                    <i class="fas fa-spa text-white text-6xl"></i>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-6 glass-effect rounded-2xl p-8 shadow-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Bookings ({{ $service->bookings->count() }})</h2>
        @if($service->bookings->isEmpty())
            <p class="text-gray-500">No bookings for this service yet.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-2 px-4 text-gray-700 font-semibold">Customer</th>
                            <th class="text-left py-2 px-4 text-gray-700 font-semibold">Date</th>
                            <th class="text-left py-2 px-4 text-gray-700 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($service->bookings->take(10) as $booking)
                            <tr class="border-b border-gray-100">
                                <td class="py-2 px-4">{{ $booking->user->name }}</td>
                                <td class="py-2 px-4">{{ $booking->booking_date->format('d M Y H:i') }}</td>
                                <td class="py-2 px-4">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs">{{ $booking->status }}</span>
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

