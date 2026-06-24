<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Display service catalog
     */
    public function index(Request $request)
    {
        $category = $request->query('category');
        
        $query = Service::active();

        if ($category) {
            $query->byCategory($category);
        }

        $services = $query->orderBy('name')->get();
        
        // Group by category for easier display
        $groupedServices = $services->groupBy('category');

        // Get all unique active categories for sidebar/filter
        $categories = Service::active()
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('catalog.index', compact('groupedServices', 'categories', 'category'));
    }

    /**
     * Display details of a specific service
     */
    public function show(Service $service)
    {
        if (!$service->is_active) {
            abort(404);
        }

        // Ambil galeri foto terkait layanan
        $service->load(['galleries' => function ($query) {
            $query->orderBy('sort_order', 'asc');
        }]);

        return view('catalog.show', compact('service'));
    }
}
