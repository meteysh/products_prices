<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class PriceFactory extends Factory
{
    const MAX = 500000;
    const MIN = 1;
    const DEC = 2;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'guid' => $this->faker->uuid(),
            'price' => $this->faker->randomFloat(self::DEC, self::MIN, self::MAX),
            'product_id'=>Product::factory()
        ];
    }
}
