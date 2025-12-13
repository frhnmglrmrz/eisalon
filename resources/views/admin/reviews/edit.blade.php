@extends('layouts.app')

@section('title', 'Edit Review - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8">
        <h1 class="text-4xl font-bold gradient-text mb-2">Edit Review</h1>
    </div>

    <div class="glass-effect rounded-2xl p-8 shadow-lg max-w-3xl">
        <form action="{{ route('admin.reviews.update', $review) }}" method="POST">
            @csrf @method('PUT')
            <div class="space-y-6">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Rating *</label>
                    <select name="rating" required class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none">
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Comment</label>
                    <textarea name="comment" rows="4" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none">{{ $review->comment }}</textarea>
                </div>
            </div>
            <div class="mt-8 flex space-x-4">
                <button type="submit" class="btn-primary text-white px-8 py-3 rounded-full font-medium">Update</button>
                <a href="{{ route('admin.reviews.index') }}" class="bg-gray-200 text-gray-700 px-8 py-3 rounded-full font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

