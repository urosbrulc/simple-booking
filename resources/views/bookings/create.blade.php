@extends('layouts.app')

@section('title', 'Create Booking')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4">Confirm Your Booking</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Booking Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Car Information</h6>
                        <p><strong>Make:</strong> {{ $car->make }}</p>
                        <p><strong>Model:</strong> {{ $car->model }}</p>
                        <p><strong>Year:</strong> {{ $car->year }}</p>
                        <p><strong>Daily Price:</strong> ${{ number_format($car->daily_price, 2) }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Booking Period</h6>
                        <p><strong>Start Date:</strong> {{ $startDate->format('M d, Y') }}</p>
                        <p><strong>End Date:</strong> {{ $endDate->format('M d, Y') }}</p>
                        <p><strong>Duration:</strong> {{ $days }} {{ $days == 1 ? 'day' : 'days' }}</p>
                        <p><strong>Total Price:</strong> ${{ number_format($totalPrice, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Booking Summary</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('bookings.store') }}">
                    @csrf
                    <input type="hidden" name="car_id" value="{{ $car->id }}">
                    <input type="hidden" name="start_date" value="{{ $startDate->format('Y-m-d') }}">
                    <input type="hidden" name="end_date" value="{{ $endDate->format('Y-m-d') }}">

                    <div class="mb-3">
                        <label class="form-label">Car</label>
                        <p class="form-control-plaintext">{{ $car->make }} {{ $car->model }} ({{ $car->year }})</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Duration</label>
                        <p class="form-control-plaintext">{{ $days }} {{ $days == 1 ? 'day' : 'days' }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Total Price</label>
                        <p class="form-control-plaintext h5 text-primary">${{ number_format($totalPrice, 2) }}</p>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Confirm Booking</button>
                        <a href="{{ route('bookings.search') }}" class="btn btn-outline-secondary">Back to Search</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
