@extends('layouts.app')

@section('title', 'View Review - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8 flex justify-between items-center">
        <h1 class="text-4xl font-bold gradient-text mb-2">Review Details</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.reviews.edit', $review) }}" class="btn-primary text-white px-6 py-3 rounded-full font-medium">Edit</a>
            <a href="{{ route('admin.reviews.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-full font-medium">Back</a>
        </div>
    </div>

    <div class="glass-effect rounded-2xl p-8 shadow-lg">
        <div class="space-y-6">
            <div>
                <h2 class="text-xl font-bold mb-2">Customer</h2>
                <p>{{ $review->user->name }} ({{ $review->user->email }})</p>
            </div>
            <div>
                <h2 class="text-xl font-bold mb-2">Service</h2>
                <p>{{ $review->service->name }}</p>
            </div>
            <div>
                <h2 class="text-xl font-bold mb-2">Rating</h2>
                <div class="flex items-center">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star text-2xl {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                    @endfor
                    <span class="ml-2 text-lg">({{ $review->rating }}/5)</span>
                </div>
            </div>
            @if($review->comment)
            <div>
                <h2 class="text-xl font-bold mb-2">Comment</h2>
                <p>{{ $review->comment }}</p>
            </div>
            @endif
            <div>
                <p class="text-sm text-gray-500">Created: {{ $review->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

