@extends('layouts.app')

@section('title', 'Edit Therapist - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8">
        <h1 class="text-4xl font-bold gradient-text mb-2">Edit Therapist</h1>
    </div>

    <div class="glass-effect rounded-2xl p-8 shadow-lg max-w-3xl">
        <form action="{{ route('admin.therapists.update', $therapist) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="space-y-6">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Name *</label>
                    <input type="text" name="name" value="{{ old('name', $therapist->name) }}" required class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Specialization *</label>
                    <input type="text" name="specialization" value="{{ old('specialization', $therapist->specialization) }}" required class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Bio</label>
                    <textarea name="bio" rows="4" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none">{{ old('bio', $therapist->bio) }}</textarea>
                </div>
                @if($therapist->photo)
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Current Photo</label>
                        <img src="{{ asset('storage/' . $therapist->photo) }}" alt="{{ $therapist->name }}" class="w-32 h-32 object-cover rounded-lg">
                    </div>
                @endif
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Photo</label>
                    <input type="file" name="photo" accept="image/*" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none">
                </div>
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_available" value="1" {{ old('is_available', $therapist->is_available) ? 'checked' : '' }} class="w-5 h-5 text-pink-500">
                        <span class="ml-2 text-gray-700 font-medium">Available</span>
                    </label>
                </div>
            </div>
            <div class="mt-8 flex space-x-4">
                <button type="submit" class="btn-primary text-white px-8 py-3 rounded-full font-medium">Update</button>
                <a href="{{ route('admin.therapists.index') }}" class="bg-gray-200 text-gray-700 px-8 py-3 rounded-full font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

