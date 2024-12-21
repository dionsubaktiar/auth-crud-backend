<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Initialize Faker
         $faker = Faker::create();

         // Define the number of records to insert
         $articleCount = 25;
         $userId = [1,2];

         // Loop to insert multiple articles
         foreach (range(1, $articleCount) as $index) {
             DB::table('data')->insert([
                 'title' => $faker->sentence, // Generate a fake title
                 'article' => $faker->paragraphs(3, true), // Generate a multi-paragraph article
                 'tanggal' => $faker->date, // Generate a random date
                 'user_id' => $faker->randomElement($userId), // Assign a random user
                 'created_at' => now(),
                 'updated_at' => now(),
             ]);
         }

         $this->command->info("$articleCount articles seeded successfully using Faker.");
        }
}
