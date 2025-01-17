<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\servicepackage;
use Faker\Factory as Faker;

class ServicePackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Regular Service Packages (4 packages)
        for ($i = 1; $i <= 4; $i++) {
            servicepackage::create([
                'kode_packages' => 'REG' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Large Service Packages (4 packages)
        for ($i = 1; $i <= 4; $i++) {
            servicepackage::create([
                'kode_packages' => 'LARGE' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
