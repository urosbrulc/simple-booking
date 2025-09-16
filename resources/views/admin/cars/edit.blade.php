@extends('layouts.app')

@section('title', 'Edit Car')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4">Edit Car</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Car Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.cars.update', $car) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="make" class="form-label">Make <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('make') is-invalid @enderror"
                                       id="make" name="make" value="{{ old('make', $car->make) }}" required>
                                @error('make')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="model" class="form-label">Model <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('model') is-invalid @enderror"
                                       id="model" name="model" value="{{ old('model', $car->model) }}" required>
                                @error('model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="year" class="form-label">Year <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('year') is-invalid @enderror"
                                       id="year" name="year" value="{{ old('year', $car->year) }}"
                                       min="1900" max="{{ date('Y') + 1 }}" required>
                                @error('year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="daily_price" class="form-label">Daily Price <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control @error('daily_price') is-invalid @enderror"
                                           id="daily_price" name="daily_price" value="{{ old('daily_price', $car->daily_price) }}"
                                           step="0.01" min="0" required>
                                    @error('daily_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="hidden" name="available" value="0">
                            <input class="form-check-input" type="checkbox" id="available" name="available"
                                   value="1" {{ old('available', $car->available) ? 'checked' : '' }}>
                            <label class="form-check-label" for="available">
                                Available for booking
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.cars.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Cars
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Car
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Car Details</h5>
            </div>
            <div class="card-body">
                <p><strong>Created:</strong> {{ $car->created_at->format('M d, Y g:i A') }}</p>
                <p><strong>Last Updated:</strong> {{ $car->updated_at->format('M d, Y g:i A') }}</p>
                <p><strong>Total Bookings:</strong> {{ $car->bookings->count() }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
