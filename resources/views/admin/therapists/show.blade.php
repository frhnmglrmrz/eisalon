@extends('layouts.app')

@section('title', 'View Therapist - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8 flex justify-between items-center">
        <h1 class="text-4xl font-bold gradient-text mb-2">{{ $therapist->name }}</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.therapists.edit', $therapist) }}" class="btn-primary text-white px-6 py-3 rounded-full font-medium">Edit</a>
            <a href="{{ route('admin.therapists.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-full font-medium">Back</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="glass-effect rounded-2xl p-8 shadow-lg">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Information</h2>
            <div class="space-y-4">
                <div>
                    <label class="text-gray-600 text-sm">Name</label>
                    <p class="text-gray-800 font-semibold text-lg">{{ $therapist->name }}</p>
                </div>
                <div>
                    <label class="text-gray-600 text-sm">Specialization</label>
                    <p class="text-gray-800"><span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">{{ ucfirst($therapist->specialization) }}</span></p>
                </div>
                <div>
                    <label class="text-gray-600 text-sm">Bio</label>
                    <p class="text-gray-800">{{ $therapist->bio ?? 'No bio' }}</p>
                </div>
                <div>
                    <label class="text-gray-600 text-sm">Status</label>
                    <p>@if($therapist->is_available)<span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">Available</span>@else<span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">Unavailable</span>@endif</p>
                </div>
            </div>
        </div>
        <div class="glass-effect rounded-2xl p-8 shadow-lg">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Photo</h2>
            @if($therapist->photo)
                <img src="{{ asset('storage/' . $therapist->photo) }}" alt="{{ $therapist->name }}" class="w-full rounded-lg">
            @else
                <div class="w-full h-64 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user text-white text-6xl"></i>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

