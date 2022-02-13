<?php

namespace Database\Seeders;

use App\Models\Price;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    const COUNT_PRICES =3;
    const COUNT_PRODUCTS =10;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()
            ->count(self::COUNT_PRODUCTS)
            ->has(Price::factory()->count(self::COUNT_PRICES))
            ->create();
    }
}
