<?php

namespace Database\Seeders;

use App\Models\kendaraan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KendaraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        kendaraan::create([
            'dealer' => 'Honda Dealer',
            'merk_kendaraan' => 'Honda',
            'model_kendaraan' => 'Vario 160',
            'warna_kendaraan' => 'Black',
            'harga_kendaraan' => 25000000
        ]);

        kendaraan::create([
            'dealer' => 'Toyota Dealer',
            'merk_kendaraan' => 'Toyota',
            'model_kendaraan' => 'Avanza',
            'warna_kendaraan' => 'Silver',
            'harga_kendaraan' => 250000000
        ]);
    }
}
