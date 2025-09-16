@extends('layouts.app')

@section('title', 'Car Details')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Car Details</h2>
            <div>
                <a href="{{ route('admin.cars.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Cars
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Car Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Make:</strong> {{ $car->make }}</p>
                        <p><strong>Model:</strong> {{ $car->model }}</p>
                        <p><strong>Year:</strong> {{ $car->year }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Daily Price:</strong> ${{ number_format($car->daily_price, 2) }}</p>
                        <p><strong>Status:</strong>
                            <span class="badge bg-{{ $car->available ? 'success' : 'danger' }}">
                                {{ $car->available ? 'Available' : 'Unavailable' }}
                            </span>
                        </p>
                        <p><strong>Created:</strong> {{ $car->created_at->format('M d, Y g:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if($car->bookings->count() > 0)
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Booking History</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($car->bookings as $booking)
                                    <tr>
                                        <td>{{ $booking->user->name }}</td>
                                        <td>{{ $booking->start_date->format('M d, Y') }}</td>
                                        <td>{{ $booking->end_date->format('M d, Y') }}</td>
                                        <td>${{ number_format($booking->total_price, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $booking->isActive() ? 'success' : 'secondary' }}">
                                                {{ $booking->isActive() ? 'Active' : 'Completed' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Statistics</h5>
            </div>
            <div class="card-body">
                <p><strong>Total Bookings:</strong> {{ $car->bookings->count() }}</p>
                <p><strong>Total Revenue:</strong> ${{ number_format($car->bookings->sum('total_price'), 2) }}</p>
                <p><strong>Average Booking Duration:</strong>
                    @if($car->bookings->count() > 0)
                        {{ number_format($car->bookings->avg('days'), 1) }} days
                    @else
                        N/A
                    @endif
                </p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Car
                    </a>
                    <form method="POST" action="{{ route('admin.cars.destroy', $car) }}"
                          onsubmit="return confirm('Are you sure you want to delete this car?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash"></i> Delete Car
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
