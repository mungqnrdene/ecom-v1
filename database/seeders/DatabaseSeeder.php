<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
        ]);

        // Create sample categories
        Category::create([
            'name' => 'Mobile Phones',
        ]);

        Category::create([
            'name' => 'Techqnology',
        ]);

        Category::create([
            'name' => 'Cars',
        ]);

        Category::create([
            'name' => 'Suitcases',
        ]);
        Category::create([
            'name' => 'Others',
        ]);
    }
}
