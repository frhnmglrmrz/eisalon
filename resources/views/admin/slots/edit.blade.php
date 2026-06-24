@extends('layouts.app')

@section('title', 'Ubah Slot Jadwal - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8">
        <a href="{{ route('admin.slot.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center mb-4 transition">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Slot
        </a>
        <h1 class="text-4xl font-bold gradient-text">Ubah Slot Jadwal</h1>
        <p class="text-gray-600 mt-1">Ubah ketersediaan atau jam pelayanan slot operasional</p>
    </div>

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl animate-fadeIn shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="glass-effect rounded-2xl p-8 shadow-lg max-w-3xl">
        <form action="{{ route('admin.slot.update', $slot) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div>
                    <label for="date" class="block text-gray-700 font-bold mb-2">Tanggal Slot <span class="text-red-500">*</span></label>
                    <input type="date" id="date" name="date" value="{{ old('date', $slot->date->format('Y-m-d')) }}" required min="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition @error('date') border-red-500 @enderror">
                    @error('date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="start_time" class="block text-gray-700 font-bold mb-2">Jam Mulai <span class="text-red-500">*</span></label>
                        <input type="time" id="start_time" name="start_time" value="{{ old('start_time', \Carbon\Carbon::parse($slot->start_time)->format('H:i')) }}" required
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition @error('start_time') border-red-500 @enderror">
                        @error('start_time')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_time" class="block text-gray-700 font-bold mb-2">Jam Selesai <span class="text-red-500">*</span></label>
                        <input type="time" id="end_time" name="end_time" value="{{ old('end_time', \Carbon\Carbon::parse($slot->end_time)->format('H:i')) }}" required
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition @error('end_time') border-red-500 @enderror">
                        @error('end_time')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="flex items-center cursor-pointer select-none">
                        <input type="checkbox" name="is_available" value="1" {{ old('is_available', $slot->is_available ? '1' : '0') == '1' ? 'checked' : '' }} 
                               class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <span class="ml-3 text-gray-700 font-semibold">Aktif & Tersedia</span>
                    </label>
                </div>
            </div>

            <div class="mt-8 flex space-x-4">
                <button type="submit" class="btn-primary text-white px-8 py-3 rounded-full font-semibold shadow-md">
                    Perbarui Slot
                </button>
                <a href="{{ route('admin.slot.index') }}" class="bg-gray-200 text-gray-700 hover:bg-gray-300 px-8 py-3 rounded-full font-semibold transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
