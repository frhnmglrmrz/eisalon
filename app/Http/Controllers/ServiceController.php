<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of services
     */
    public function index(Request $request)
    {
        $query = Service::with(['reviews'])->active();

        // Filter by category
        if ($request->has('category')) {
            $query->byCategory($request->category);
        }

        // Search
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sorting
        $sortBy = $request->get('sort', 'name');
        $sortOrder = $request->get('order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $services = $query->paginate(12);

        // Append computed attributes
        $services->getCollection()->transform(function ($service) {
            $service->average_rating = $service->average_rating;
            $service->total_reviews = $service->total_reviews;
            return $service;
        });

        return view('services.index', compact('services'));
    }

    /**
     * Display the specified service
     */
    public function show(Service $service)
    {
        $service->load(['reviews.user']);
        $service->average_rating = $service->average_rating;
        $service->total_reviews = $service->total_reviews;

        // Get related services
        $relatedServices = Service::active()
            ->where('category', $service->category)
            ->where('id', '!=', $service->id)
            ->limit(4)
            ->get();

        return view('services.show', compact('service', 'relatedServices'));
    }

    /**
     * Show the form for creating a new service (Admin only)
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created service (Admin only)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:15',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $service = Service::create($validated);

        return redirect()->route('services.show', $service)
            ->with('success', 'Service created successfully!');
    }

    /**
     * Show the form for editing the specified service (Admin only)
     */
    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified service (Admin only)
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:15',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($validated);

        return redirect()->route('services.show', $service)
            ->with('success', 'Service updated successfully!');
    }

    /**
     * Remove the specified service (Admin only)
     */
    public function destroy(Service $service)
    {
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route('services.index')
            ->with('success', 'Service deleted successfully!');
    }

    /**
     * Get services by category (API endpoint)
     */
    public function getByCategory($category)
    {
        $services = Service::active()
            ->byCategory($category)
            ->get();

        return response()->json($services);
    }
}
