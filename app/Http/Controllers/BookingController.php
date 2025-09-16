<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index(): View
    {
        try {
            $bookings = auth()->user()->bookings()
                ->with('car')
                ->orderBy('created_at', 'desc')
                ->get();

            return view('bookings.index', compact('bookings'));
        } catch (\Exception $e) {
            // Return empty collection if there's an error
            $bookings = collect();
            return view('bookings.index', compact('bookings'));
        }
    }

    public function search(Request $request): View
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $cars = collect();

        if ($startDate && $endDate) {
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

            $cars = Car::where('available', true)
                ->whereDoesntHave('bookings', function ($query) use ($startDate, $endDate) {
                    $query->where(function ($q) use ($startDate, $endDate) {
                        $q->whereBetween('start_date', [$startDate, $endDate])
                            ->orWhereBetween('end_date', [$startDate, $endDate])
                            ->orWhere(function ($subQ) use ($startDate, $endDate) {
                                $subQ->where('start_date', '<=', $startDate)
                                    ->where('end_date', '>=', $endDate);
                            });
                    });
                })
                ->get();
        }

        return view('bookings.search', compact('cars', 'startDate', 'endDate'));
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

        $car = Car::findOrFail($carId);
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        if (!$car->isAvailableForDates($startDate, $endDate)) {
            return redirect()->route('bookings.search')
                ->with('error', 'Car is not available for the selected dates.');
        }

        $days = $startDate->diffInDays($endDate) + 1;
        $totalPrice = $days * $car->daily_price;

        return view('bookings.create', compact('car', 'startDate', 'endDate', 'days', 'totalPrice'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date'
        ]);

        $car = Car::findOrFail($validated['car_id']);
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);

        if (!$car->isAvailableForDates($startDate, $endDate)) {
            return redirect()->route('bookings.search')
                ->with('error', 'Car is no longer available for the selected dates.');
        }

        $days = $startDate->diffInDays($endDate) + 1;
        $totalPrice = $days * $car->daily_price;

        Booking::create([
            'user_id' => auth()->id(),
            'car_id' => $car->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_price' => $totalPrice
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        if (!$booking->canBeCancelled()) {
            return redirect()->route('bookings.index')
                ->with('error', 'Cannot cancel booking that has already started.');
        }

        $booking->delete();

        return redirect()->route('bookings.index')
            ->with('success', 'Booking cancelled successfully.');
    }
}
