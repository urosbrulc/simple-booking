<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SimpleHomeController extends Controller
{
    public function index(): View
    {
        try {
            $cars = DB::table('cars')
                ->where('available', true)
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();

            return view('home', compact('cars'));
        } catch (\Exception $e) {
            $cars = collect();
            return view('home', compact('cars'));
        }
    }
}
