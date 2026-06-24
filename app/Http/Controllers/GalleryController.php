<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Service;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display gallery page
     */
    public function index(Request $request)
    {
        $serviceId = $request->query('service_id');
        
        $query = Gallery::with('service');

        if ($serviceId) {
            $query->where('service_id', $serviceId);
        }

        $galleries = $query->orderBy('sort_order', 'asc')->latest()->get();
        $services = Service::active()->orderBy('name')->get();

        return view('gallery.index', compact('galleries', 'services', 'serviceId'));
    }
}
