<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;



/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->pluck('id')->random(),
            'brand_id' => Brand::inRandomOrder()->pluck('id')->random(),
            'title' => $this->faker->name,
            'specifications' => json_encode([
                'length' => $this->faker->randomNumber(2),
                'width' => $this->faker->randomNumber(2),
                'height' => $this->faker->randomNumber(2),
                'weight' => $this->faker->randomNumber(3),
            ]),
            'description' => $this->faker->name,
            'price' => $this->faker->randomNumber(1),
            'in_stoch' => $this->faker->randomNumber(2),
        ];
    }
}
