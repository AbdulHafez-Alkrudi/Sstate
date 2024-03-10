<?php

namespace Database\Factories;

use App\Models\Street;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class StreetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_EN'=>$this->faker->name,
            'name_AR'=>$this->faker->name,
            'latitude'=>$this->faker->numberBetween(0 , 1000),
            'longitude'=>$this->faker->numberBetween(0 , 1000)
        ];
    }
}
