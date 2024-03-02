<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price'=>$this->faker->numberBetween(100 , 10000),
            'floor'=>$this->faker->numberBetween(0 , 400),
            'number_of_rooms'=>$this->faker->numberBetween(1 , 1000),
            'number_of_kitchens'=>$this->faker->numberBetween(1 , 100),
            'number_of_bathrooms'=>$this->faker->numberBetween(1 , 100),
            'space'=>$this->faker->numberBetween(10 , 10000),
            'rent'=>$this->faker->boolean
        ];
    }
}
