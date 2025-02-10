<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\unit;
use App\Models\customer;
use Faker\Factory as Faker;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $customers = customer::all(); // Get all customers

        // Create 10 units
        for ($i = 1; $i <= 100; $i++) {
            $customer = $customers->random(); // Randomly select a customer

            unit::create([
                'nopol' => strtoupper($faker->bothify('??-###-???')),
                'tipe' => $faker->randomElement(['Truck', 'Bus', 'Pickup']),
                'no_rangka' => strtoupper($faker->lexify('????????????????????')),
                'no_mesin' => strtoupper($faker->lexify('???????????????')),
                'driver' => $faker->name,
                'tahun' => $faker->year,
                'japo_kir' => $faker->date,
                'japo_pajak' => $faker->date,
                'japo_stnk' => $faker->date,
                'status' => $status = $faker->boolean, // Random boolean
                'japo_kontrak' => $status ? $faker->date : null, // NULL jika status false
                'id_customer' => $customer->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
