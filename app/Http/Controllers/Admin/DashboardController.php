<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Motorcycle;
use App\Services\MotorcycleService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected MotorcycleService $motorcycleService
    ) {}

    /**
     * Display the employee dashboard overview.
     */
    public function index(): View
    {
        $stats = $this->motorcycleService->getDashboardStats();

        $recentMotorcycles = Motorcycle::with(['brand', 'primaryImage'])
            ->latest('id')
            ->take(6)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentMotorcycles'));
    }
}

