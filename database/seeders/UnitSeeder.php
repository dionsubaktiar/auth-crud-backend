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
        for ($i = 1; $i <= 10; $i++) {
            $customer = $customers->random(); // Randomly select a customer

            unit::create([
                'nopol' => strtoupper($faker->bothify('??-###-???')), // Random vehicle number plate
                'tipe' => $faker->randomElement(['Truck', 'Bus', 'Pickup']), // Random type (e.g., SUV, Sedan)
                'no_rangka' => strtoupper($faker->lexify('????????????????????')), // Random chassis number
                'no_mesin' => strtoupper($faker->lexify('???????????????')), // Random engine number
                'driver' => $faker->name, // Random driver name
                'tahun' => $faker->year, // Random year
                'japo_kir' => $faker->date, // Random KIR date
                'japo_pajak' => $faker->date, // Random tax date
                'japo_stnk' => $faker->date, // Random STNK date
                'japo_kontrak' => $faker->date, // Random contract date
                'status' => $faker->boolean, // Random status (active/inactive)
                'id_customer' => $customer->id, // Link to random customer
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
