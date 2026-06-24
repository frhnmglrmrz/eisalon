@extends('layouts.app')

@section('title', 'Kelola Layanan - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-indigo-950 mb-2">Kelola Layanan</h1>
            <p class="text-sm text-gray-600">Tambah, ubah, dan nonaktifkan layanan salon rambut</p>
        </div>
        <a href="{{ route('admin.layanan.create') }}" class="bg-indigo-900 hover:bg-indigo-950 text-white px-6 py-3 rounded-full text-sm font-semibold transition shadow-sm">
            <i class="fas fa-plus mr-2"></i>Tambah Layanan Baru
        </a>
    </div>

    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-200/60">
        @if($services->isEmpty())
            <div class="text-center py-12">
                <i class="fas fa-cut text-5xl text-gray-300 mb-4 animate-float"></i>
                <h3 class="text-lg font-bold text-indigo-950 mb-2">Layanan belum tersedia</h3>
                <p class="text-sm text-gray-500 mb-6 font-light">Mulai dengan menambahkan layanan baru untuk pelanggan Anda.</p>
                <a href="{{ route('admin.layanan.create') }}" class="bg-indigo-900 hover:bg-indigo-950 text-white px-6 py-3 rounded-full text-sm font-semibold transition">
                    <i class="fas fa-plus mr-2"></i>Tambah Layanan
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="border-b border-gray-200 text-gray-500 font-semibold uppercase tracking-wider text-xs">
                            <th class="py-4 px-4">Foto</th>
                            <th class="py-4 px-4">Nama Layanan</th>
                            <th class="py-4 px-4">Kategori</th>
                            <th class="py-4 px-4">Harga</th>
                            <th class="py-4 px-4">Durasi</th>
                            <th class="py-4 px-4">Status</th>
                            <th class="py-4 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($services as $service)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-4 px-4">
                                    @if($service->photo)
                                        <img src="{{ asset('storage/' . $service->photo) }}" alt="{{ $service->name }}" class="w-16 h-16 object-cover rounded-xl shadow-inner">
                                    @else
                                        <div class="w-16 h-16 bg-indigo-50 rounded-xl flex items-center justify-center border border-indigo-100">
                                            <i class="fas fa-cut text-indigo-900 text-lg opacity-40"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <div class="font-bold text-indigo-950">{{ $service->name }}</div>
                                    <div class="text-xs text-gray-500 font-light mt-0.5 line-clamp-2">{{ Str::limit($service->description, 50) }}</div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="px-2.5 py-1 bg-indigo-50 text-indigo-900 border border-indigo-100 rounded-full text-xs font-semibold">
                                        {{ $service->category }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 font-bold text-indigo-950">
                                    Rp {{ number_format($service->price, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-4 text-gray-600 font-light">
                                    {{ $service->duration_minutes }} menit
                                </td>
                                <td class="py-4 px-4">
                                    @if($service->is_active)
                                        <span class="px-2.5 py-1 bg-green-50 text-green-700 border border-green-200 rounded-full text-xs font-semibold">Aktif</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-red-50 text-red-700 border border-red-200 rounded-full text-xs font-semibold">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex space-x-3 text-base">
                                        <a href="{{ route('admin.layanan.show', $service) }}" class="text-indigo-600 hover:text-indigo-900" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.layanan.edit', $service) }}" class="text-yellow-600 hover:text-yellow-800" title="Ubah">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.layanan.destroy', $service) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
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
