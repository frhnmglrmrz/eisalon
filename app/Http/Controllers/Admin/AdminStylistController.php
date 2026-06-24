<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stylist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminStylistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stylists = Stylist::latest()->paginate(10);
        return view('admin.stylists.index', compact('stylists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.stylists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('stylists', 'public');
        }

        $validated['is_available'] = $request->has('is_available') ? $request->boolean('is_available') : true;

        Stylist::create($validated);

        return redirect()->route('admin.stylist.index')
            ->with('success', 'Stylist berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stylist $stylist)
    {
        $stylist->load(['bookings.service', 'bookings.slot']);
        return view('admin.stylists.show', compact('stylist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stylist $stylist)
    {
        return view('admin.stylists.edit', compact('stylist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stylist $stylist)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            if ($stylist->photo) {
                Storage::disk('public')->delete($stylist->photo);
            }
            $validated['photo'] = $request->file('photo')->store('stylists', 'public');
        }

        $validated['is_available'] = $request->has('is_available') ? $request->boolean('is_available') : false;

        $stylist->update($validated);

        return redirect()->route('admin.stylist.index')
            ->with('success', 'Stylist berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stylist $stylist)
    {
        // Cek jika stylist memiliki booking
        if ($stylist->bookings()->exists()) {
            // Ubah is_available menjadi false
            $stylist->update(['is_available' => false]);
            return redirect()->route('admin.stylist.index')
                ->with('warning', 'Stylist tidak dapat dihapus karena memiliki riwayat booking. Status diubah menjadi Tidak Tersedia.');
        }

        if ($stylist->photo) {
            Storage::disk('public')->delete($stylist->photo);
        }

        $stylist->delete();

        return redirect()->route('admin.stylist.index')
            ->with('success', 'Stylist berhasil dihapus.');
    }
}
