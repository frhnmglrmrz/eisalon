@extends('layouts.app')

@section('title', 'Edit Service - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8">
        <h1 class="text-4xl font-bold gradient-text mb-2">Edit Service</h1>
        <p class="text-gray-600">Update service information</p>
    </div>

    <div class="glass-effect rounded-2xl p-8 shadow-lg max-w-3xl">
        <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-gray-700 font-bold mb-2">Service Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $service->name) }}" required
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-gray-700 font-bold mb-2">Description *</label>
                    <textarea id="description" name="description" rows="4" required
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none @error('description') border-red-500 @enderror">{{ old('description', $service->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price and Duration -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="price" class="block text-gray-700 font-bold mb-2">Price (Rp) *</label>
                        <input type="number" id="price" name="price" value="{{ old('price', $service->price) }}" step="0.01" min="0" required
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none @error('price') border-red-500 @enderror">
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="duration" class="block text-gray-700 font-bold mb-2">Duration (minutes) *</label>
                        <input type="number" id="duration" name="duration" value="{{ old('duration', $service->duration) }}" min="1" required
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none @error('duration') border-red-500 @enderror">
                        @error('duration')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-gray-700 font-bold mb-2">Category *</label>
                    <select id="category" name="category" required
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none @error('category') border-red-500 @enderror">
                        <option value="">Select Category</option>
                        <option value="facial" {{ old('category', $service->category) == 'facial' ? 'selected' : '' }}>Facial</option>
                        <option value="massage" {{ old('category', $service->category) == 'massage' ? 'selected' : '' }}>Massage</option>
                        <option value="hair_treatment" {{ old('category', $service->category) == 'hair_treatment' ? 'selected' : '' }}>Hair Treatment</option>
                        <option value="nail_care" {{ old('category', $service->category) == 'nail_care' ? 'selected' : '' }}>Nail Care</option>
                        <option value="body_treatment" {{ old('category', $service->category) == 'body_treatment' ? 'selected' : '' }}>Body Treatment</option>
                        <option value="other" {{ old('category', $service->category) == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('category')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Image -->
                @if($service->image)
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Current Image</label>
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-32 h-32 object-cover rounded-lg">
                    </div>
                @endif

                <!-- Image -->
                <div>
                    <label for="image" class="block text-gray-700 font-bold mb-2">Service Image</label>
                    <input type="file" id="image" name="image" accept="image/*"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none @error('image') border-red-500 @enderror">
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Is Active -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}
                            class="w-5 h-5 text-pink-500 border-gray-300 rounded focus:ring-pink-500">
                        <span class="ml-2 text-gray-700 font-medium">Service is active</span>
                    </label>
                </div>
            </div>

            <div class="mt-8 flex space-x-4">
                <button type="submit" class="btn-primary text-white px-8 py-3 rounded-full font-medium">
                    <i class="fas fa-save mr-2"></i>Update Service
                </button>
                <a href="{{ route('admin.services.index') }}" class="bg-gray-200 text-gray-700 px-8 py-3 rounded-full font-medium hover:bg-gray-300">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

