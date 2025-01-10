<?php

namespace Database\Seeders;

use App\Models\konsumen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KonsumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        konsumen::create([
            'username' => 'john_doe',
            'email' => 'john@example.com',
            'nama' => 'John Doe',
            'nik' => '1234567890123456',
            'tanggal_lahir' => '1985-01-01',
            'status_perkawinan' => 'Single',
            'data_pasangan' => null,
            'password' => Hash::make('password123')
        ]);
    }
}
