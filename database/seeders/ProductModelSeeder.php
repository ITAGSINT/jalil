<?php

namespace Database\Seeders;

use App\Models\CarModel;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = Product::all();
        $roles = CarModel::all();

        foreach ($users as $user) {
            $user->models()->attach(
                $roles->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}
