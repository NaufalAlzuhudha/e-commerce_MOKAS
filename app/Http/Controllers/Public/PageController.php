<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Motorcycle;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display About Us page.
     */
    public function about(): View
    {
        $stats = [
            'total_verified' => Motorcycle::count(),
            'brands_count' => Brand::count(),
            'sold_count' => Motorcycle::where('status', Motorcycle::STATUS_SOLD)->count(),
        ];

        return view('public.about', compact('stats'));
    }

    /**
     * Display Contact page.
     */
    public function contact(): View
    {
        return view('public.contact');
    }
}
