<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMotorcycleRequest;
use App\Http\Requests\UpdateMotorcycleRequest;
use App\Models\Brand;
use App\Models\Motorcycle;
use App\Services\MotorcycleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MotorcycleController extends Controller
{
    public function __construct(
        protected MotorcycleService $motorcycleService
    ) {}

    /**
     * Display a listing of motorcycles with filter bar & search.
     */
    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'brand_id', 'status']);

        $query = Motorcycle::with(['brand', 'primaryImage', 'images']);

        if (!empty($filters['search'])) {
            $keyword = trim($filters['search']);
            $query->where(function ($q) use ($keyword) {
                $q->where('model', 'LIKE', "%{$keyword}%")
                  ->orWhere('color', 'LIKE', "%{$keyword}%")
                  ->orWhereHas('brand', function ($bq) use ($keyword) {
                      $bq->where('name', 'LIKE', "%{$keyword}%");
                  });
            });
        }

        if (!empty($filters['brand_id'])) {
            $query->where('brand_id', $filters['brand_id']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $motorcycles = $query->latest('id')->paginate(10)->withQueryString();
        $brands = Brand::orderBy('name')->get();

        return view('admin.motorcycles.index', compact('motorcycles', 'brands', 'filters'));
    }

    /**
     * Show the form for creating a new motorcycle.
     */
    public function create(): View
    {
        $brands = Brand::orderBy('name')->get();
        return view('admin.motorcycles.create', compact('brands'));
    }

    /**
     * Store a newly created motorcycle in storage.
     */
    public function store(StoreMotorcycleRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $images = $request->file('images', []);
        $primaryIndex = $request->input('primary_image_index', 0);

        $motorcycle = $this->motorcycleService->createMotorcycle(
            $validated,
            $images,
            (int) $primaryIndex,
            (int) auth()->id()
        );

        return redirect()
            ->route('admin.motorcycles.index')
            ->with('success', "Unit motor '{$motorcycle->title}' berhasil ditambahkan.");
    }

    /**
     * Show the form for editing the specified motorcycle.
     */
    public function edit(Motorcycle $motorcycle): View
    {
        $motorcycle->load(['brand', 'images']);
        $brands = Brand::orderBy('name')->get();

        return view('admin.motorcycles.edit', compact('motorcycle', 'brands'));
    }

    /**
     * Update the specified motorcycle in storage.
     */
    public function update(UpdateMotorcycleRequest $request, Motorcycle $motorcycle): RedirectResponse
    {
        $validated = $request->validated();
        $newImages = $request->file('images', []);
        $primaryImageId = $request->input('primary_image_id');

        $this->motorcycleService->updateMotorcycle(
            $motorcycle,
            $validated,
            $newImages,
            $primaryImageId ? (int) $primaryImageId : null
        );

        return redirect()
            ->route('admin.motorcycles.index')
            ->with('success', "Unit motor '{$motorcycle->title}' berhasil diperbarui.");
    }

    /**
     * Remove the specified motorcycle from storage.
     */
    public function destroy(Motorcycle $motorcycle): RedirectResponse
    {
        $title = $motorcycle->title;
        $this->motorcycleService->deleteMotorcycle($motorcycle);

        return redirect()
            ->route('admin.motorcycles.index')
            ->with('success', "Unit motor '{$title}' dan seluruh foto terkait berhasil dihapus.");
    }
}

