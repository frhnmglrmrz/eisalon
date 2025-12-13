@extends('layouts.app')

@section('title', 'Manage Services - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold gradient-text mb-2">Manage Services</h1>
            <p class="text-gray-600">Create, edit, and manage salon services</p>
        </div>
        <a href="{{ route('admin.services.create') }}" class="btn-primary text-white px-6 py-3 rounded-full font-medium">
            <i class="fas fa-plus mr-2"></i>Add New Service
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="glass-effect rounded-2xl p-6 shadow-lg">
        @if($services->isEmpty())
            <div class="text-center py-12">
                <i class="fas fa-spa text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-400 mb-2">No services yet</h3>
                <p class="text-gray-500 mb-6">Create your first service to get started</p>
                <a href="{{ route('admin.services.create') }}" class="btn-primary text-white px-6 py-3 rounded-full font-medium">
                    <i class="fas fa-plus mr-2"></i>Add Service
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Image</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Name</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Category</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Price</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Duration</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Status</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $service)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="py-4 px-4">
                                    @if($service->image)
                                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-16 h-16 object-cover rounded-lg">
                                    @else
                                        <div class="w-16 h-16 bg-gradient-to-br from-pink-400 to-orange-400 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-spa text-white text-xl"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <div class="font-medium text-gray-800">{{ $service->name }}</div>
                                    <div class="text-sm text-gray-500 line-clamp-2">{{ Str::limit($service->description, 50) }}</div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-medium">
                                        {{ ucfirst($service->category) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="font-medium text-gray-800">Rp {{ number_format($service->price, 0, ',', '.') }}</div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="text-gray-600">{{ $service->duration }} min</div>
                                </td>
                                <td class="py-4 px-4">
                                    @if($service->is_active)
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">Active</span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">Inactive</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.services.show', $service) }}" class="text-blue-600 hover:text-blue-800" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.services.edit', $service) }}" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $services->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

