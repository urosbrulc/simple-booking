<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SimpleCarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cars = [
            [
                'make' => 'Toyota',
                'model' => 'Camry',
                'year' => 2023,
                'daily_price' => 45.00,
                'available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'make' => 'Honda',
                'model' => 'Civic',
                'year' => 2022,
                'daily_price' => 40.00,
                'available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'make' => 'BMW',
                'model' => '3 Series',
                'year' => 2023,
                'daily_price' => 80.00,
                'available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'make' => 'Mercedes-Benz',
                'model' => 'C-Class',
                'year' => 2022,
                'daily_price' => 85.00,
                'available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'make' => 'Audi',
                'model' => 'A4',
                'year' => 2023,
                'daily_price' => 75.00,
                'available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('cars')->insert($cars);
    }
}
