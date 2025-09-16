@extends('layouts.app')

@section('title', 'Search Cars')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4">Search Available Cars</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Search Filters</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('bookings.search') }}">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                               value="{{ $startDate ?? '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                               value="{{ $endDate ?? '' }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Search Cars</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        @if(isset($cars))
            @if($cars->count() > 0)
                <h4 class="mb-3">Available Cars ({{ $cars->count() }} found)</h4>
                <div class="row">
                    @foreach($cars as $car)
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $car->make }} {{ $car->model }}</h5>
                                    <p class="card-text">
                                        <strong>Year:</strong> {{ $car->year }}<br>
                                        <strong>Daily Price:</strong> ${{ number_format($car->daily_price, 2) }}<br>
                                        <strong>Total for {{ $startDate->diffInDays($endDate) + 1 }} days:</strong>
                                        ${{ number_format(($startDate->diffInDays($endDate) + 1) * $car->daily_price, 2) }}
                                    </p>
                                    <a href="{{ route('bookings.create', [
                                        'car_id' => $car->id,
                                        'start_date' => $startDate->format('Y-m-d'),
                                        'end_date' => $endDate->format('Y-m-d')
                                    ]) }}" class="btn btn-primary">Book This Car</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-warning">
                    <h4>No cars available</h4>
                    <p>No cars are available for the selected date range. Please try different dates.</p>
                </div>
            @endif
        @else
            <div class="alert alert-info">
                <h4>Select dates to search</h4>
                <p>Please select start and end dates to search for available cars.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');

    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    startDateInput.min = today;

    // Update end date minimum when start date changes
    startDateInput.addEventListener('change', function() {
        if (this.value) {
            endDateInput.min = this.value;
        }
    });
});
</script>
@endpush
