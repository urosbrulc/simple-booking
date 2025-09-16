<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{

    protected $fillable = [
        'make',
        'model',
        'year',
        'daily_price',
        'available'
    ];

    protected $casts = [
        'available' => 'boolean',
        'daily_price' => 'decimal:2',
        'year' => 'integer'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isAvailableForDates($startDate, $endDate)
    {
        if (!$this->available) {
            return false;
        }

        return !$this->bookings()
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                          ->where('end_date', '>=', $endDate);
                    });
            })
            ->exists();
    }
}
