<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Display the welcome/homepage
     */
    public function index()
    {
        // Get featured services (top 6 services)
        $featuredServices = Service::with(['reviews'])
            ->active()
            ->latest()
            ->take(6)
            ->get()
            ->map(function ($service) {
                $service->average_rating = $service->average_rating;
                $service->total_reviews = $service->total_reviews;
                return $service;
            });

        // Get latest testimonials/reviews
        $testimonials = Review::with(['user', 'service'])
            ->latest()
            ->take(5)
            ->get();

        // Get service categories for stats
        $categories = Service::active()
            ->select('category')
            ->distinct()
            ->pluck('category');

        // Statistics
        $stats = [
            'total_services' => Service::active()->count(),
            'total_reviews' => Review::count(),
            'categories' => $categories->count(),
            'average_rating' => Review::avg('rating') ?? 0,
        ];

        return view('home', compact('featuredServices', 'testimonials', 'stats'));
    }
}

