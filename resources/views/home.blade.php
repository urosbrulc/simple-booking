@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="jumbotron bg-primary text-white p-5 rounded mb-4">
            <h1 class="display-4">Welcome to CarBooking</h1>
            <p class="lead">Find and book the perfect car for your next trip</p>
            @guest
                <a class="btn btn-light btn-lg" href="{{ route('register') }}" role="button">Get Started</a>
            @else
                <a class="btn btn-light btn-lg" href="{{ route('bookings.search') }}" role="button">Search Cars</a>
            @endguest
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h2 class="mb-4">Available Cars</h2>
    </div>
</div>

<div class="row">
    @forelse($cars as $car)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $car->make }} {{ $car->model }}</h5>
                    <p class="card-text">
                        <strong>Year:</strong> {{ $car->year }}<br>
                        <strong>Daily Price:</strong> ${{ number_format($car->daily_price, 2) }}
                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-{{ $car->available ? 'success' : 'danger' }}">
                            {{ $car->available ? 'Available' : 'Unavailable' }}
                        </span>
                        @auth
                            <a href="{{ route('bookings.search') }}" class="btn btn-primary btn-sm">
                                Book Now
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                                Login to Book
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">
                <h4>No cars available at the moment</h4>
                <p>Please check back later or contact us for more information.</p>
            </div>
        </div>
    @endforelse
</div>

@auth
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Ready to book a car?</h5>
                    <p class="card-text">Search for available cars by date and make your booking.</p>
                    <a href="{{ route('bookings.search') }}" class="btn btn-primary">Search Cars</a>
                </div>
            </div>
        </div>
    </div>
@endauth
@endsection
