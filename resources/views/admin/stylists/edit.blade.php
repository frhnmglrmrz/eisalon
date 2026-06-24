@extends('layouts.app')

@section('title', 'Ubah Stylist - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8">
        <a href="{{ route('admin.stylist.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center mb-4 transition">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Stylist
        </a>
        <h1 class="text-4xl font-bold gradient-text">Ubah Data Stylist</h1>
        <p class="text-gray-600 mt-1">Perbarui informasi untuk stylist {{ $stylist->name }}</p>
    </div>

    <div class="glass-effect rounded-2xl p-8 shadow-lg max-w-3xl">
        <form action="{{ route('admin.stylist.update', $stylist) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-gray-700 font-bold mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $stylist->name) }}" required 
                           class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition @error('name') border-red-500 @enderror" 
                           placeholder="Contoh: Andi Wijaya">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="specialization" class="block text-gray-700 font-bold mb-2">Spesialisasi</label>
                    <input type="text" id="specialization" name="specialization" value="{{ old('specialization', $stylist->specialization) }}" 
                           class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition @error('specialization') border-red-500 @enderror"
                           placeholder="Contoh: Potong Pria, Pewarnaan, Hair Treatment (pisahkan dengan koma)">
                    <p class="text-gray-400 text-xs mt-1">Gunakan kata kunci kategori yang sesuai (Potong, Pewarnaan, Treatment, Styling) agar otomatis terintegrasi dengan filter pencarian pelanggan.</p>
                    @error('specialization')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="bio" class="block text-gray-700 font-bold mb-2">Bio / Deskripsi Singkat</label>
                    <textarea id="bio" name="bio" rows="4" 
                              class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition @error('bio') border-red-500 @enderror"
                              placeholder="Ceritakan sedikit tentang latar belakang, sertifikasi, atau pengalaman stylist...">{{ old('bio', $stylist->bio) }}</textarea>
                    @error('bio')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                @if($stylist->photo)
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Foto Saat Ini</label>
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('storage/' . $stylist->photo) }}" alt="{{ $stylist->name }}" class="w-24 h-24 object-cover rounded-xl shadow-sm border border-gray-200">
                            <span class="text-sm text-gray-500">Stylist sudah memiliki foto profil. Unggah foto baru jika ingin menggantinya.</span>
                        </div>
                    </div>
                @endif

                <div>
                    <label for="photo" class="block text-gray-700 font-bold mb-2">Ganti Foto Profil</label>
                    <input type="file" id="photo" name="photo" accept="image/*" 
                           class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition @error('photo') border-red-500 @enderror">
                    <p class="text-gray-400 text-xs mt-1">Format gambar: JPEG, PNG, JPG, GIF (Max. 2MB)</p>
                    @error('photo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="flex items-center cursor-pointer select-none">
                        <input type="checkbox" name="is_available" value="1" {{ old('is_available', $stylist->is_available ? '1' : '0') == '1' ? 'checked' : '' }} 
                               class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <span class="ml-3 text-gray-700 font-semibold">Tersedia untuk Booking</span>
                    </label>
                </div>
            </div>

            <div class="mt-8 flex space-x-4">
                <button type="submit" class="btn-primary text-white px-8 py-3 rounded-full font-semibold shadow-md">
                    Perbarui Stylist
                </button>
                <a href="{{ route('admin.stylist.index') }}" class="bg-gray-200 text-gray-700 hover:bg-gray-300 px-8 py-3 rounded-full font-semibold transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
