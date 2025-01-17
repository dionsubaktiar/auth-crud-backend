<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\item;
use App\Models\Part;
use App\Models\ServicePackage;
use Faker\Factory as Faker;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get all available service packages to reference
        $servicePackages = ServicePackage::all();

        // Create Items
        $parts = Part::whereIn('nama_barang', [
            'Engine Oil', 'Grease', 'Air Filter', 'Fuel Filter',
            'Brake Pads', 'Oil Filter', 'Fan Belt', 'Coolant'
        ])->get();

        foreach ($parts as $key => $part) {
            // Randomly assign each item to one of the available service packages
            $package = $servicePackages->random();

            item::create([
                'sparepart' => $part->nama_barang,
                'harga_part' => $part->harga,
                'harga_jasa' => $part->jasa,
                'kode_packages' => $package->kode_packages, // Linking to the service package
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
