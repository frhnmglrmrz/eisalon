<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Display e-catalog page with all services
     */
    public function index(Request $request)
    {
        $query = Service::with(['reviews'])->active();

        // Filter by category
        if ($request->has('category') && $request->category !== '') {
            $query->byCategory($request->category);
        }

        // Search
        if ($request->has('search') && $request->search !== '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Get all categories for filter
        $categories = Service::active()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        // Get services grouped by category
        $servicesByCategory = Service::active()
            ->with(['reviews'])
            ->orderBy('category')
            ->orderBy('name')
            ->get()
            ->groupBy('category');

        // Paginated services for main display
        $services = $query->orderBy('category')->orderBy('name')->paginate(12);

        // Append computed attributes
        $services->getCollection()->transform(function ($service) {
            $service->average_rating = $service->average_rating;
            $service->total_reviews = $service->total_reviews;
            return $service;
        });

        return view('catalog.index', compact('services', 'categories', 'servicesByCategory'));
    }

    /**
     * Show booking form for WhatsApp
     */
    public function showBookingForm(Service $service)
    {
        return view('catalog.booking-form', compact('service'));
    }
}
