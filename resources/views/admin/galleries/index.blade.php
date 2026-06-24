@extends('layouts.app')

@section('title', 'Kelola Galeri - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold gradient-text mb-2">Kelola Galeri</h1>
            <p class="text-gray-600">Tambah, ubah, dan susun foto portofolio salon rambut</p>
        </div>
        <a href="{{ route('admin.galeri.create') }}" class="btn-primary text-white px-6 py-3 rounded-full font-semibold shadow-md inline-flex items-center">
            <i class="fas fa-plus mr-2"></i>Unggah Foto Baru
        </a>
    </div>

    <div class="glass-effect rounded-2xl p-6 shadow-lg">
        @if($galleries->isEmpty())
            <div class="text-center py-12">
                <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-images text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Belum ada foto galeri</h3>
                <p class="text-gray-500 mb-6">Mulai unggah foto hasil potongan rambut atau pewarnaan stylist untuk portofolio.</p>
                <a href="{{ route('admin.galeri.create') }}" class="btn-primary text-white px-6 py-3 rounded-full font-semibold shadow-md inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i>Unggah Foto Pertama
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($galleries as $gallery)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition-all flex flex-col justify-between">
                        <div>
                            <!-- Foto Thumbnail -->
                            <div class="aspect-square w-full bg-gray-100 relative">
                                <img src="{{ asset('storage/' . $gallery->photo) }}" alt="{{ $gallery->caption ?? 'Portofolio' }}" class="w-full h-full object-cover">
                                @if($gallery->service)
                                    <span class="absolute top-3 left-3 px-2.5 py-1 bg-indigo-900/90 text-white text-[10px] uppercase font-bold tracking-wider rounded-md">
                                        {{ $gallery->service->name }}
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Caption/Info -->
                            <div class="p-4 space-y-2">
                                <p class="text-sm text-gray-700 font-medium line-clamp-2">{{ $gallery->caption ?? 'Tanpa Keterangan' }}</p>
                                <div class="text-xs text-gray-400">Urutan Tampil: {{ $gallery->sort_order }}</div>
                            </div>
                        </div>

                        <!-- Aksi Buttons -->
                        <div class="p-4 pt-0 border-t border-gray-50 flex items-center justify-between text-sm">
                            <a href="{{ route('admin.galeri.edit', $gallery) }}" class="text-amber-500 hover:text-amber-700 font-semibold inline-flex items-center transition">
                                <i class="fas fa-edit mr-1"></i>Ubah
                            </a>
                            <form action="{{ route('admin.galeri.destroy', $gallery) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto portofolio ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold inline-flex items-center transition">
                                    <i class="fas fa-trash-alt mr-1"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 border-t border-gray-100 pt-6">
                {{ $galleries->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
