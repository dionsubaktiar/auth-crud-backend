<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\part;
use Faker\Factory as Faker;

class PartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $parts = [];

        // Generate 30 parts
        for ($i = 1; $i <= 90; $i++) {
            $parts[] = [
                'part_number' => 'PN' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'nama_barang' => $faker->randomElement([
                    'Engine Oil', 'Grease', 'Air Filter', 'Fuel Filter',
                    'Brake Pads', 'Clutch Plate', 'Radiator Hose',
                    'Suspension Spring', 'Oil Filter', 'Shock Absorber'
                ]),
                'merk' => $faker->company,
                'kendaraan' => $faker->randomElement(['Truck', 'Bus', 'Pickup']),
                'harga' => $faker->numberBetween(50000, 500000),
                'jasa' => $faker->numberBetween(25000, 150000),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        part::insert($parts);
    }
}
