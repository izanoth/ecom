<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Shipping;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ShippingFactory extends Factory
{
    protected $model = Shipping::class;

    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->pluck('id')->random(),
            'name' => $this->faker->name,
            'address' => $this->faker->streetAddress,
            'complement' => $this->faker->secondaryAddress,
            'zipcode' => $this->faker->postcode,
            'city' => $this->faker->city,
            'district' => $this->faker->state,
            'phone' => $this->faker->phoneNumber,
        ];
    }
}


