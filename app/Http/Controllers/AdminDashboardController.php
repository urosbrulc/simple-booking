<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Booking;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $totalCars = Car::count();
        $totalBookings = Booking::count();
        $totalRevenue = Booking::sum('total_price');
        $availableCars = Car::where('available', true)->count();

        $recentBookings = Booking::with(['user', 'car'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalCars',
            'totalBookings',
            'totalRevenue',
            'availableCars',
            'recentBookings'
        ));
    }
}
