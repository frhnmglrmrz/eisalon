<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Therapist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminTherapistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $therapists = Therapist::latest()->paginate(15);
        return view('admin.therapists.index', compact('therapists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.therapists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('therapists', 'public');
        }

        $validated['is_available'] = $request->has('is_available');

        Therapist::create($validated);

        return redirect()->route('admin.therapists.index')
            ->with('success', 'Therapist created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Therapist $therapist)
    {
        $therapist->load(['bookings.user', 'bookings.service']);
        return view('admin.therapists.show', compact('therapist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Therapist $therapist)
    {
        return view('admin.therapists.edit', compact('therapist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Therapist $therapist)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            if ($therapist->photo) {
                Storage::disk('public')->delete($therapist->photo);
            }
            $validated['photo'] = $request->file('photo')->store('therapists', 'public');
        }

        $validated['is_available'] = $request->has('is_available');

        $therapist->update($validated);

        return redirect()->route('admin.therapists.index')
            ->with('success', 'Therapist updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Therapist $therapist)
    {
        if ($therapist->photo) {
            Storage::disk('public')->delete($therapist->photo);
        }

        $therapist->delete();

        return redirect()->route('admin.therapists.index')
            ->with('success', 'Therapist deleted successfully.');
    }
}
