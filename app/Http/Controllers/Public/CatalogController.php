<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Motorcycle;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    /**
     * Display catalog of published motorcycles with multi-criteria filters.
     */
    public function index(Request $request): View
    {
        $filters = $request->only([
            'search',
            'brand_id',
            'min_price',
            'max_price',
            'min_year',
            'max_year',
            'transmission',
            'sort',
            'include_sold',
        ]);

        $query = Motorcycle::with(['brand', 'primaryImage', 'images']);

        // Default: only published, unless explicitly including sold units
        if (!empty($filters['include_sold']) && $filters['include_sold'] == '1') {
            $query->whereIn('status', [Motorcycle::STATUS_PUBLISHED, Motorcycle::STATUS_SOLD]);
        } else {
            $query->published();
        }

        // Apply filters
        $motorcycles = $query->filter($filters)->paginate(12)->withQueryString();

        $brands = Brand::withCount(['motorcycles' => function ($q) {
            $q->published();
        }])->orderBy('name')->get();

        $years = Motorcycle::published()
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        return view('public.catalog.index', compact('motorcycles', 'brands', 'years', 'filters'));
    }

    /**
     * Display a specific motorcycle's detail page.
     */
    public function show(int $id): View
    {
        $motorcycle = Motorcycle::with(['brand', 'images', 'creator'])->findOrFail($id);

        // Security requirement: Customers cannot access draft or inactive products
        if ($motorcycle->status === Motorcycle::STATUS_DRAFT || $motorcycle->status === Motorcycle::STATUS_INACTIVE) {
            abort(404, 'Kendaraan tidak ditemukan atau belum dipublikasikan.');
        }

        // Related motorcycles recommendation
        $relatedMotorcycles = Motorcycle::with(['brand', 'primaryImage'])
            ->published()
            ->where('id', '!=', $motorcycle->id)
            ->where(function ($q) use ($motorcycle) {
                $q->where('brand_id', $motorcycle->brand_id)
                  ->orWhereBetween('price', [$motorcycle->price * 0.7, $motorcycle->price * 1.3]);
            })
            ->latest('id')
            ->take(4)
            ->get();

        return view('public.catalog.show', compact('motorcycle', 'relatedMotorcycles'));
    }
}
