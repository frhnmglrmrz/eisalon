@extends('layouts.app')

@section('title', 'Tambah Layanan - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8">
        <a href="{{ route('admin.layanan.index') }}" class="inline-flex items-center text-sm font-semibold text-indigo-900 hover:text-indigo-950 mb-3 transition">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Layanan
        </a>
        <h1 class="text-3xl font-bold text-indigo-950 mb-2">Tambah Layanan Baru</h1>
        <p class="text-sm text-gray-600">Buat layanan kecantikan atau perawatan rambut baru untuk salon</p>
    </div>

    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-200/60 max-w-3xl">
        <form action="{{ route('admin.layanan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-gray-700 font-bold mb-2">Nama Layanan *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Contoh: Potong Rambut Pria"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-900 focus:outline-none @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-gray-700 font-bold mb-2">Kategori *</label>
                    <select id="category" name="category" required
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-900 focus:outline-none @error('category') border-red-500 @enderror">
                        <option value="">Pilih Kategori</option>
                        <option value="Potong" {{ old('category') == 'Potong' ? 'selected' : '' }}>Potong</option>
                        <option value="Pewarnaan" {{ old('category') == 'Pewarnaan' ? 'selected' : '' }}>Pewarnaan</option>
                        <option value="Treatment" {{ old('category') == 'Treatment' ? 'selected' : '' }}>Treatment</option>
                        <option value="Styling" {{ old('category') == 'Styling' ? 'selected' : '' }}>Styling</option>
                        <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('category')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-gray-700 font-bold mb-2">Deskripsi *</label>
                    <textarea id="description" name="description" rows="4" required placeholder="Jelaskan detail perawatan..."
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-900 focus:outline-none @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price and Duration -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="price" class="block text-gray-700 font-bold mb-2">Harga (Rp) *</label>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" min="0" required placeholder="Contoh: 50000"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-900 focus:outline-none @error('price') border-red-500 @enderror">
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="duration_minutes" class="block text-gray-700 font-bold mb-2">Durasi (Menit) *</label>
                        <input type="number" id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes') }}" min="1" required placeholder="Contoh: 30"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-900 focus:outline-none @error('duration_minutes') border-red-500 @enderror">
                        @error('duration_minutes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Photo -->
                <div>
                    <label for="photo" class="block text-gray-700 font-bold mb-2">Foto Layanan</label>
                    <input type="file" id="photo" name="photo" accept="image/*"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-900 focus:outline-none @error('photo') border-red-500 @enderror">
                    @error('photo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Is Active -->
                <div>
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                            class="w-5 h-5 text-indigo-900 border-gray-300 rounded focus:ring-indigo-950">
                        <span class="ml-2 text-gray-700 font-semibold text-sm">Layanan aktif dan dapat dipesan</span>
                    </label>
                </div>
            </div>

            <div class="mt-8 flex space-x-4">
                <button type="submit" class="bg-indigo-900 hover:bg-indigo-950 text-white px-8 py-3 rounded-full text-sm font-semibold shadow-sm transition">
                    <i class="fas fa-save mr-2"></i>Simpan Layanan
                </button>
                <a href="{{ route('admin.layanan.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-8 py-3 rounded-full text-sm font-semibold transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
