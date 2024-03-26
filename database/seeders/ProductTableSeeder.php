<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Category_Product;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            $category = Category::factory()->create();

            // Associa a nova categoria ao produto
            Category_Product::create([
                "product_id" => $product->id,
                "category_id" => $category->id
            ]);
           
        }
    }
}
