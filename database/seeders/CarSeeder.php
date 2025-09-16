<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;

class CarSeeder extends Seeder
{

    public function run(): void
    {
        $cars = [
            [
                'make' => 'Toyota',
                'model' => 'Camry',
                'year' => 2023,
                'daily_price' => 45.00,
                'available' => true,
            ],
            [
                'make' => 'Honda',
                'model' => 'Civic',
                'year' => 2022,
                'daily_price' => 40.00,
                'available' => true,
            ],
            [
                'make' => 'BMW',
                'model' => '3 Series',
                'year' => 2023,
                'daily_price' => 80.00,
                'available' => true,
            ],
            [
                'make' => 'Mercedes-Benz',
                'model' => 'C-Class',
                'year' => 2022,
                'daily_price' => 85.00,
                'available' => true,
            ],
            [
                'make' => 'Audi',
                'model' => 'A4',
                'year' => 2023,
                'daily_price' => 75.00,
                'available' => true,
            ],
            [
                'make' => 'Ford',
                'model' => 'Mustang',
                'year' => 2022,
                'daily_price' => 90.00,
                'available' => true,
            ],
            [
                'make' => 'Chevrolet',
                'model' => 'Malibu',
                'year' => 2023,
                'daily_price' => 50.00,
                'available' => true,
            ],
            [
                'make' => 'Nissan',
                'model' => 'Altima',
                'year' => 2022,
                'daily_price' => 42.00,
                'available' => true,
            ],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}
