@extends('layouts.app')

@section('title', 'Create Service - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8">
        <h1 class="text-4xl font-bold gradient-text mb-2">Create New Service</h1>
        <p class="text-gray-600">Add a new service to your salon</p>
    </div>

    <div class="glass-effect rounded-2xl p-8 shadow-lg max-w-3xl">
        <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-gray-700 font-bold mb-2">Service Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-gray-700 font-bold mb-2">Description *</label>
                    <textarea id="description" name="description" rows="4" required
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price and Duration -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="price" class="block text-gray-700 font-bold mb-2">Price (Rp) *</label>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0" required
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none @error('price') border-red-500 @enderror">
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="duration" class="block text-gray-700 font-bold mb-2">Duration (minutes) *</label>
                        <input type="number" id="duration" name="duration" value="{{ old('duration') }}" min="1" required
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
                        <option value="facial" {{ old('category') == 'facial' ? 'selected' : '' }}>Facial</option>
                        <option value="massage" {{ old('category') == 'massage' ? 'selected' : '' }}>Massage</option>
                        <option value="hair_treatment" {{ old('category') == 'hair_treatment' ? 'selected' : '' }}>Hair Treatment</option>
                        <option value="nail_care" {{ old('category') == 'nail_care' ? 'selected' : '' }}>Nail Care</option>
                        <option value="body_treatment" {{ old('category') == 'body_treatment' ? 'selected' : '' }}>Body Treatment</option>
                        <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('category')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

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
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                            class="w-5 h-5 text-pink-500 border-gray-300 rounded focus:ring-pink-500">
                        <span class="ml-2 text-gray-700 font-medium">Service is active</span>
                    </label>
                </div>
            </div>

            <div class="mt-8 flex space-x-4">
                <button type="submit" class="btn-primary text-white px-8 py-3 rounded-full font-medium">
                    <i class="fas fa-save mr-2"></i>Create Service
                </button>
                <a href="{{ route('admin.services.index') }}" class="bg-gray-200 text-gray-700 px-8 py-3 rounded-full font-medium hover:bg-gray-300">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

