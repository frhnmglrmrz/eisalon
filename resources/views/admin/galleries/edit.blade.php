@extends('layouts.app')

@section('title', 'Ubah Foto Galeri - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8">
        <a href="{{ route('admin.galeri.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center mb-4 transition">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Galeri
        </a>
        <h1 class="text-4xl font-bold gradient-text">Ubah Foto Galeri</h1>
        <p class="text-gray-600 mt-1">Perbarui rincian foto portofolio hasil karya salon</p>
    </div>

    <div class="glass-effect rounded-2xl p-8 shadow-lg max-w-3xl">
        <form action="{{ route('admin.galeri.update', $gallery) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <!-- Foto Saat Ini -->
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Foto Saat Ini</label>
                    <div class="flex items-center space-x-6">
                        <img src="{{ asset('storage/' . $gallery->photo) }}" alt="{{ $gallery->caption ?? 'Portofolio' }}" class="w-48 h-48 object-cover rounded-xl shadow-sm border border-gray-200">
                        <div class="text-sm text-gray-500">
                            Unggah file foto baru di bawah jika Anda ingin mengganti gambar saat ini.
                        </div>
                    </div>
                </div>

                <!-- Ganti File Foto -->
                <div>
                    <label for="photo" class="block text-gray-700 font-bold mb-2">Ganti File Foto</label>
                    <input type="file" id="photo" name="photo" accept="image/*"
                           class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition @error('photo') border-red-500 @enderror">
                    <p class="text-gray-400 text-xs mt-1">Format gambar: JPEG, PNG, JPG, GIF (Max. 2MB)</p>
                    @error('photo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Hubungkan ke Layanan (Opsional) -->
                <div>
                    <label for="service_id" class="block text-gray-700 font-bold mb-2">Tautkan ke Layanan (Opsional)</label>
                    <select id="service_id" name="service_id" 
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition">
                        <option value="">-- Tidak Ada Layanan Terkait --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id', $gallery->service_id) == $service->id ? 'selected' : '' }}>
                                {{ $service->name }} ({{ $service->category }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Caption / Deskripsi -->
                <div>
                    <label for="caption" class="block text-gray-700 font-bold mb-2">Keterangan Foto (Caption)</label>
                    <input type="text" id="caption" name="caption" value="{{ old('caption', $gallery->caption) }}"
                           class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition @error('caption') border-red-500 @enderror"
                           placeholder="Contoh: Model Rambut Fade Pompadour oleh Stylist Andi">
                    @error('caption')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sort Order / Urutan Tampil -->
                <div>
                    <label for="sort_order" class="block text-gray-700 font-bold mb-2">Urutan Tampil (Prioritas)</label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $gallery->sort_order) }}" required min="0"
                           class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition @error('sort_order') border-red-500 @enderror">
                    @error('sort_order')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 flex space-x-4">
                <button type="submit" class="btn-primary text-white px-8 py-3 rounded-full font-semibold shadow-md">
                    Perbarui Portofolio
                </button>
                <a href="{{ route('admin.galeri.index') }}" class="bg-gray-200 text-gray-700 hover:bg-gray-300 px-8 py-3 rounded-full font-semibold transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
