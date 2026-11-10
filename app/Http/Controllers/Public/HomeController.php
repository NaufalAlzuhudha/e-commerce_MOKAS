<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Motorcycle;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the showroom landing homepage.
     */
    public function index(): View
    {
        $featuredMotorcycles = Motorcycle::with(['brand', 'primaryImage', 'images'])
            ->published()
            ->latest('id')
            ->take(6)
            ->get();

        $brands = Brand::withCount(['motorcycles' => function ($query) {
            $query->published();
        }])->get();

        $stats = [
            'total_units' => Motorcycle::published()->count(),
            'sold_units' => Motorcycle::where('status', Motorcycle::STATUS_SOLD)->count(),
            'brands_count' => $brands->count(),
        ];

        return view('public.home', compact('featuredMotorcycles', 'brands', 'stats'));
    }
}

