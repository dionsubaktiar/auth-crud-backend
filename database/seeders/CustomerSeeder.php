<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\customer;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create 10 customers
        for ($i = 1; $i <= 10; $i++) {
            customer::create([
                'nama_perusahaan' => $faker->company,
                'alamat' => $faker->address,
                'pic' => $faker->name,
                'kontak' => $faker->phoneNumber,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
