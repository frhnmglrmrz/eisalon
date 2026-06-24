<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::with('service')
            ->orderBy('sort_order', 'asc')
            ->latest()
            ->paginate(12);

        return view('admin.galleries.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::active()->orderBy('name')->get();
        return view('admin.galleries.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'caption' => 'nullable|string|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'integer',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('galleries', 'public');
        }

        $validated['sort_order'] = $request->input('sort_order', 0);

        Gallery::create($validated);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Foto portofolio berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $galeri)
    {
        $gallery = $galeri;
        $services = Service::active()->orderBy('name')->get();
        return view('admin.galleries.edit', compact('gallery', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $galeri)
    {
        $gallery = $galeri;
        $validated = $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'caption' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'integer',
        ]);

        if ($request->hasFile('photo')) {
            if ($gallery->photo) {
                Storage::disk('public')->delete($gallery->photo);
            }
            $validated['photo'] = $request->file('photo')->store('galleries', 'public');
        }

        $validated['sort_order'] = $request->input('sort_order', $gallery->sort_order);

        $gallery->update($validated);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Foto portofolio berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $galeri)
    {
        $gallery = $galeri;
        if ($gallery->photo) {
            Storage::disk('public')->delete($gallery->photo);
        }

        $gallery->delete();

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Foto portofolio berhasil dihapus.');
    }
}
