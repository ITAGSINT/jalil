<?php

use Database\Seeders\ProductModelSeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Run the individual seeders in order
        $this->call([
            ProductSeeder::class,
            ProductModelSeeder::class,

        ]);
    }
}
