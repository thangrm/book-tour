<?php

namespace Database\Factories;

use App\Models\Destination;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DestinationFactory extends Factory
{
    protected $model = Destination::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->sentence;
        $slug = Str::slug($name, '-');
        return [
            'name' => $name,
            'slug' => $slug,
            'image' => $this->faker->filePath(),
            'status' => $this->faker->numberBetween(1, 2),
            'created_at' => time(),
            'updated_at' => time(),

        ];
    }
}
