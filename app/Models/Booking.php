<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'car_id',
        'start_date',
        'end_date',
        'total_price'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_price' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function getDaysAttribute()
    {
        if (!$this->start_date || !$this->end_date) {
            return 0;
        }
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    public function calculateTotalPrice()
    {
        if (!$this->start_date || !$this->end_date || !$this->car) {
            return 0;
        }
        $days = $this->start_date->diffInDays($this->end_date) + 1;
        return $days * $this->car->daily_price;
    }

    public function isActive()
    {
        if (!$this->end_date) {
            return false;
        }
        return $this->end_date >= Carbon::today();
    }

    public function canBeCancelled()
    {
        if (!$this->start_date) {
            return false;
        }
        return $this->start_date > Carbon::today();
    }
}
