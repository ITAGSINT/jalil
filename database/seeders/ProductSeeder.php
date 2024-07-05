<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = Category::all();

        foreach ($category as $cat) {
            for ($i = 0; $i < 4; $i++) {


                DB::table('products')->insert([
                    "category_id" => $cat->id,
                    "main_image" => "http=>//127.0.0.1=>8000/storage/images/img_66435cb3c1bda.png",
                    "name" => Str::random(10),
                    "description" => Str::random(10),
                    "size" => "10R",
                    "products_quantity" => 22,
                    "products_price" => "120.00",
                    "discount_price" => "0.00",
                    "country" => null,
                    "company_id" => 1,
                    "brand_id" => 1,
                    "manufacturer_id" => 1,
                    "sku" => null,
                    "code" => "2222",
                    "capacity" => "100",
                    "capacityUnit" => "mah",
                    "promotional_text" => "k",
                    "netWeight" => 10,
                    "netWeightUnit" => "kg",
                    "grossWeight" => 20,
                    "grossWeightUnit" => "kg",
                    "width" => 30,
                    "widthUnit" => "mm",
                    "length" => 40,
                    "lengthUnit" => "mm",
                    "height" => 50,
                    "heightUnit" => "mm",
                    "warrantyPeriod" => 60,
                    "warrantyType" => "hh",
                    "shippingWeight" => 70,
                    "shippingDimensions" => "700",

                ]);
            }
        }
    }
}
