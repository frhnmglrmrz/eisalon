@extends('layouts.app')

@section('title', 'Manage Therapists - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold gradient-text mb-2">Manage Therapists</h1>
            <p class="text-gray-600">Create, edit, and manage therapists</p>
        </div>
        <a href="{{ route('admin.therapists.create') }}" class="btn-primary text-white px-6 py-3 rounded-full font-medium">
            <i class="fas fa-plus mr-2"></i>Add New Therapist
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="glass-effect rounded-2xl p-6 shadow-lg">
        @if($therapists->isEmpty())
            <div class="text-center py-12">
                <i class="fas fa-user-md text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-400 mb-2">No therapists yet</h3>
                <a href="{{ route('admin.therapists.create') }}" class="btn-primary text-white px-6 py-3 rounded-full font-medium">
                    <i class="fas fa-plus mr-2"></i>Add Therapist
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Photo</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Name</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Specialization</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Status</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($therapists as $therapist)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="py-4 px-4">
                                    @if($therapist->photo)
                                        <img src="{{ asset('storage/' . $therapist->photo) }}" alt="{{ $therapist->name }}" class="w-16 h-16 object-cover rounded-full">
                                    @else
                                        <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-white text-xl"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <div class="font-medium text-gray-800">{{ $therapist->name }}</div>
                                    @if($therapist->bio)
                                        <div class="text-sm text-gray-500 line-clamp-2">{{ Str::limit($therapist->bio, 50) }}</div>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                                        {{ ucfirst($therapist->specialization) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    @if($therapist->is_available)
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">Available</span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">Unavailable</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.therapists.show', $therapist) }}" class="text-blue-600 hover:text-blue-800"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('admin.therapists.edit', $therapist) }}" class="text-yellow-600 hover:text-yellow-800"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.therapists.destroy', $therapist) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $therapists->links() }}</div>
        @endif
    </div>
</div>
@endsection
