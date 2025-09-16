<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Carbon\Carbon;

class SimpleCarSearchController extends Controller
{
    public function search(Request $request): View
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $cars = collect();

        if ($startDate && $endDate) {
            try {
                $startDate = Carbon::parse($startDate);
                $endDate = Carbon::parse($endDate);

                if ($startDate->isAfter($endDate)) {
                    return view('bookings.search', compact('cars'))
                        ->with('error', 'Start date must be before end date.');
                }

                if ($startDate->isBefore(Carbon::today())) {
                    return view('bookings.search', compact('cars'))
                        ->with('error', 'Start date cannot be in the past.');
                }


                $cars = DB::table('cars')
                    ->where('available', true)
                    ->whereNotExists(function ($query) use ($startDate, $endDate) {
                        $query->select(DB::raw(1))
                            ->from('bookings')
                            ->whereRaw('bookings.car_id = cars.id')
                            ->where(function ($q) use ($startDate, $endDate) {
                                $q->whereBetween('start_date', [$startDate, $endDate])
                                    ->orWhereBetween('end_date', [$startDate, $endDate])
                                    ->orWhere(function ($subQ) use ($startDate, $endDate) {
                                        $subQ->where('start_date', '<=', $startDate)
                                            ->where('end_date', '>=', $endDate);
                                    });
                            });
                    })
                    ->get();
            } catch (\Exception $e) {
                $cars = collect();
            }
        }

        return view('bookings.search', compact('cars', 'startDate', 'endDate'));
    }
}
