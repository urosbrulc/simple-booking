@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>My Bookings</h2>
            <a href="{{ route('bookings.search') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Booking
            </a>
        </div>
    </div>
</div>

@if($bookings && $bookings->count() > 0)
    <div class="row">
        @foreach($bookings as $booking)
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title">{{ $booking->make }} {{ $booking->model }}</h5>
                            <span class="badge bg-{{ \Carbon\Carbon::parse($booking->end_date)->gte(\Carbon\Carbon::today()) ? 'success' : 'secondary' }}">
                                {{ \Carbon\Carbon::parse($booking->end_date)->gte(\Carbon\Carbon::today()) ? 'Active' : 'Completed' }}
                            </span>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p class="mb-1"><strong>Year:</strong> {{ $booking->year }}</p>
                                <p class="mb-1"><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($booking->start_date)->format('M d, Y') }}</p>
                                <p class="mb-1"><strong>End Date:</strong> {{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}</p>
                            </div>
                            <div class="col-6">
                                @php
                                    $days = \Carbon\Carbon::parse($booking->start_date)->diffInDays(\Carbon\Carbon::parse($booking->end_date)) + 1;
                                @endphp
                                <p class="mb-1"><strong>Duration:</strong> {{ $days }} {{ $days == 1 ? 'day' : 'days' }}</p>
                                <p class="mb-1"><strong>Daily Price:</strong> ${{ number_format($booking->daily_price, 2) }}</p>
                                <p class="mb-1"><strong>Total Price:</strong> ${{ number_format($booking->total_price, 2) }}</p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <small class="text-muted">
                                Booked on {{ \Carbon\Carbon::parse($booking->created_at)->format('M d, Y g:i A') }}
                            </small>
                            @if(\Carbon\Carbon::parse($booking->start_date)->gt(\Carbon\Carbon::today()))
                                <form method="POST" action="{{ route('bookings.cancel', $booking->id) }}"
                                      onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        Cancel Booking
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <h4>No bookings found</h4>
                    <p class="text-muted">You haven't made any bookings yet.</p>
                    <a href="{{ route('bookings.search') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Make Your First Booking
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
