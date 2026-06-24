<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Gallery;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the welcome/homepage
     */
    public function index()
    {
        // Ambil data layanan unggulan (is_active=true, limit 6)
        $featuredServices = Service::active()
            ->latest()
            ->take(6)
            ->get();

        // Ambil data galeri terbaru (limit 8)
        $latestGalleries = Gallery::with('service')
            ->orderBy('sort_order', 'asc')
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('featuredServices', 'latestGalleries'));
    }
}
