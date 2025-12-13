@extends('layouts.app')

@section('title', 'Manage Reviews - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8">
        <h1 class="text-4xl font-bold gradient-text mb-2">Manage Reviews</h1>
        <p class="text-gray-600">View and manage customer reviews</p>
    </div>

    <div class="glass-effect rounded-2xl p-6 shadow-lg">
        <form method="GET" class="mb-6 flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="px-4 py-2 rounded-xl border-2 border-gray-200">
            <select name="rating" class="px-4 py-2 rounded-xl border-2 border-gray-200">
                <option value="">All Ratings</option>
                @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                @endfor
            </select>
            <button type="submit" class="btn-primary text-white px-6 py-2 rounded-full">Filter</button>
        </form>

        @if($reviews->isEmpty())
            <div class="text-center py-12">
                <i class="fas fa-star text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-400 mb-2">No reviews yet</h3>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Customer</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Service</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Rating</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Comment</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reviews as $review)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-4 px-4">{{ $review->user->name }}</td>
                                <td class="py-4 px-4">{{ $review->service->name }}</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                        @endfor
                                        <span class="ml-2">({{ $review->rating }})</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4">{{ Str::limit($review->comment, 50) }}</td>
                                <td class="py-4 px-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.reviews.show', $review) }}" class="text-blue-600"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('admin.reviews.edit', $review) }}" class="text-yellow-600"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
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
            <div class="mt-6">{{ $reviews->links() }}</div>
        @endif
    </div>
</div>
@endsection

