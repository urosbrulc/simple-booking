<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class SimpleBookingController extends Controller
{
    public function index(): View
    {
        try {
            $userId = Auth::id();

            $bookings = DB::table('bookings')
                ->join('cars', 'bookings.car_id', '=', 'cars.id')
                ->where('bookings.user_id', $userId)
                ->select('bookings.*', 'cars.make', 'cars.model', 'cars.year', 'cars.daily_price')
                ->orderBy('bookings.created_at', 'desc')
                ->get();

            return view('bookings.index', compact('bookings'));
        } catch (\Exception $e) {
            $bookings = collect();
            return view('bookings.index', compact('bookings'));
        }
    }

    public function create(Request $request): View
    {
        $carId = $request->get('car_id');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        if (!$carId || !$startDate || !$endDate) {
            return redirect()->route('bookings.search')
                ->with('error', 'Invalid booking parameters.');
        }

        try {
            $car = DB::table('cars')->where('id', $carId)->first();
            if (!$car) {
                return redirect()->route('bookings.search')
                    ->with('error', 'Car not found.');
            }

            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);
            $days = $startDate->diffInDays($endDate) + 1;
            $totalPrice = $days * $car->daily_price;

            return view('bookings.create', compact('car', 'startDate', 'endDate', 'days', 'totalPrice'));
        } catch (\Exception $e) {
            return redirect()->route('bookings.search')
                ->with('error', 'Error processing booking request.');
        }
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date'
        ]);

        try {
            $userId = Auth::id();
            $startDate = Carbon::parse($validated['start_date']);
            $endDate = Carbon::parse($validated['end_date']);
            $days = $startDate->diffInDays($endDate) + 1;

            $car = DB::table('cars')->where('id', $validated['car_id'])->first();
            $totalPrice = $days * $car->daily_price;

            DB::table('bookings')->insert([
                'user_id' => $userId,
                'car_id' => $validated['car_id'],
                'start_date' => $startDate,
                'end_date' => $endDate,
                'total_price' => $totalPrice,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('bookings.index')
                ->with('success', 'Booking created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('bookings.search')
                ->with('error', 'Error creating booking.');
        }
    }

    public function cancel($bookingId): RedirectResponse
    {
        try {
            $userId = Auth::id();

            $booking = DB::table('bookings')
                ->where('id', $bookingId)
                ->where('user_id', $userId)
                ->first();

            if (!$booking) {
                return redirect()->route('bookings.index')
                    ->with('error', 'Booking not found.');
            }

            $startDate = Carbon::parse($booking->start_date);
            if ($startDate <= Carbon::today()) {
                return redirect()->route('bookings.index')
                    ->with('error', 'Cannot cancel booking that has already started.');
            }

            DB::table('bookings')->where('id', $bookingId)->delete();

            return redirect()->route('bookings.index')
                ->with('success', 'Booking cancelled successfully.');
        } catch (\Exception $e) {
            return redirect()->route('bookings.index')
                ->with('error', 'Error cancelling booking.');
        }
    }
}
