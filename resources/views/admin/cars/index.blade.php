@extends('layouts.app')

@section('title', 'Manage Cars')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Manage Cars</h2>
            <a href="{{ route('admin.cars.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Car
            </a>
        </div>
    </div>
</div>

@if($cars->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Make</th>
                                    <th>Model</th>
                                    <th>Year</th>
                                    <th>Daily Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cars as $car)
                                    <tr>
                                        <td>{{ $car->id }}</td>
                                        <td>{{ $car->make }}</td>
                                        <td>{{ $car->model }}</td>
                                        <td>{{ $car->year }}</td>
                                        <td>${{ number_format($car->daily_price, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $car->available ? 'success' : 'danger' }}">
                                                {{ $car->available ? 'Available' : 'Unavailable' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.cars.show', $car) }}" class="btn btn-outline-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin.cars.destroy', $car) }}"
                                                      onsubmit="return confirm('Are you sure you want to delete this car?')"
                                                      style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            {{ $cars->links() }}
        </div>
    </div>
@else
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-car fa-3x text-muted mb-3"></i>
                    <h4>No cars found</h4>
                    <p class="text-muted">Start by adding your first car to the system.</p>
                    <a href="{{ route('admin.cars.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add First Car
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
