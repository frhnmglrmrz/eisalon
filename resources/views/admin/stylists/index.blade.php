@extends('layouts.app')

@section('title', 'Kelola Stylist - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold gradient-text mb-2">Kelola Stylist</h1>
            <p class="text-gray-600">Tambah, ubah, dan kelola stylist salon</p>
        </div>
        <a href="{{ route('admin.stylist.create') }}" class="btn-primary text-white px-6 py-3 rounded-full font-medium shadow-md">
            <i class="fas fa-plus mr-2"></i>Tambah Stylist Baru
        </a>
    </div>

    <div class="glass-effect rounded-2xl p-6 shadow-lg">
        @if($stylists->isEmpty())
            <div class="text-center py-12">
                <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-user-friends text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Belum ada stylist</h3>
                <p class="text-gray-500 mb-6">Mulai tambahkan stylist yang bekerja di Alan's Art Salon.</p>
                <a href="{{ route('admin.stylist.create') }}" class="btn-primary text-white px-6 py-3 rounded-full font-medium shadow-md">
                    <i class="fas fa-plus mr-2"></i>Tambah Stylist
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Foto</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Nama</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Spesialisasi</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Status</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stylists as $stylist)
                            <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                                <td class="py-4 px-4">
                                    @if($stylist->photo)
                                        <img src="{{ asset('storage/' . $stylist->photo) }}" alt="{{ $stylist->name }}" class="w-16 h-16 object-cover rounded-full shadow-sm border border-gray-200">
                                    @else
                                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center shadow-sm">
                                            <i class="fas fa-user text-white text-xl"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <div class="font-bold text-gray-800">{{ $stylist->name }}</div>
                                    @if($stylist->bio)
                                        <div class="text-sm text-gray-500 line-clamp-2 max-w-sm mt-1">{{ Str::limit($stylist->bio, 80) }}</div>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    @if($stylist->specialization)
                                        <span class="px-3 py-1 bg-indigo-50 text-indigo-700 border border-indigo-100 rounded-full text-xs font-semibold">
                                            {{ $stylist->specialization }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-sm">Umum</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    @if($stylist->is_available)
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                            Tersedia
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">
                                            Tidak Tersedia
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('admin.stylist.show', $stylist) }}" class="text-indigo-600 hover:text-indigo-800 transition" title="Lihat detail">
                                            <i class="fas fa-eye text-lg"></i>
                                        </a>
                                        <a href="{{ route('admin.stylist.edit', $stylist) }}" class="text-amber-500 hover:text-amber-700 transition" title="Ubah data">
                                            <i class="fas fa-edit text-lg"></i>
                                        </a>
                                        <form action="{{ route('admin.stylist.destroy', $stylist) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus stylist ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition" title="Hapus stylist">
                                                <i class="fas fa-trash text-lg"></i>
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
                {{ $stylists->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
