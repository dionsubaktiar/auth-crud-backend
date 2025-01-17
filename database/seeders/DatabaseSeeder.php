<?php

namespace Database\Seeders;

use App\Models\kendaraan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(KendaraanSeeder::class);
        $this->call(KonsumenSeeder::class);
        $this->call([
            PartSeeder::class,
            ServicePackageSeeder::class,
            ItemSeeder::class,
            CustomerSeeder::class,
            UnitSeeder::class
        ]);
    }
}
