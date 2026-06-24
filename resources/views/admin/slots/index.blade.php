@extends('layouts.app')

@section('title', 'Kelola Slot Jadwal - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8 flex flex-col md:flex-row md:justify-between md:items-center">
        <div>
            <h1 class="text-4xl font-bold gradient-text mb-2">Kelola Slot Jadwal</h1>
            <p class="text-gray-600">Atur ketersediaan slot waktu operasional salon</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <a href="{{ route('admin.slot.create') }}" class="btn-primary text-white px-6 py-3 rounded-full font-semibold shadow-md inline-flex items-center">
                <i class="fas fa-plus mr-2"></i>Tambah Slot
            </a>
        </div>
    </div>

    <!-- Filter Tanggal -->
    <div class="glass-effect rounded-2xl p-6 shadow-lg mb-8">
        <form action="{{ route('admin.slot.index') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
            <div class="w-full md:w-64">
                <label for="date" class="block text-sm font-semibold text-gray-700 mb-2">Filter Berdasarkan Tanggal</label>
                <input type="date" id="date" name="date" value="{{ request('date') }}" 
                       class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition text-sm">
            </div>
            <div class="flex space-x-2 w-full md:w-auto">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-semibold transition text-sm shadow-sm w-full md:w-auto">
                    Filter
                </button>
                @if(request()->filled('date'))
                    <a href="{{ route('admin.slot.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2.5 rounded-xl font-semibold transition text-sm text-center w-full md:w-auto">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Data Slot -->
    <div class="glass-effect rounded-2xl p-6 shadow-lg">
        @if($slots->isEmpty())
            <div class="text-center py-12">
                <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-calendar-times text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Slot jadwal tidak ditemukan</h3>
                <p class="text-gray-500 mb-6">Belum ada slot waktu untuk tanggal ini atau jadwal belum di-generate.</p>
                <a href="{{ route('admin.slot.create') }}" class="btn-primary text-white px-6 py-3 rounded-full font-semibold shadow-md">
                    <i class="fas fa-plus mr-2"></i>Tambah Slot Baru
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Tanggal</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Waktu Mulai</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Waktu Selesai</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Status Ketersediaan</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($slots as $slot)
                            <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                                <td class="py-4 px-4 font-semibold text-gray-800">
                                    {{ \Carbon\Carbon::parse($slot->date)->format('d M Y') }}
                                </td>
                                <td class="py-4 px-4 text-gray-700">
                                    {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}
                                </td>
                                <td class="py-4 px-4 text-gray-700">
                                    {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                                </td>
                                <td class="py-4 px-4">
                                    @if($slot->is_available)
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                            Aktif / Tersedia
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">
                                            Nonaktif / Penuh
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('admin.slot.edit', $slot) }}" class="text-amber-500 hover:text-amber-700 transition" title="Ubah slot">
                                            <i class="fas fa-edit text-lg"></i>
                                        </a>
                                        <form action="{{ route('admin.slot.destroy', $slot) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus slot jadwal ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition" title="Hapus slot">
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
                {{ $slots->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
