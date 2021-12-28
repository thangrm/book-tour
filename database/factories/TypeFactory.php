<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'status' => $this->faker->numberBetween(1, 2),
            'created_at' => time(),
            'updated_at' => time(),
        ];
    }
}
