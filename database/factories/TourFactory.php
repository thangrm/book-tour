<?php

namespace Database\Factories;

use App\Models\Destination;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->sentence;
        $slug = Str::slug($name);
        $listDestination = Destination::where('id', '>', 0)->get('id');
        $listType = Type::where('id', '>', 0)->get('id');

        return [
            'name' => $name,
            'slug' => $slug,
            'destination_id' => $this->faker->randomElement($listDestination),
            'type_id' => $this->faker->randomElement($listType),
            'image' => $this->faker->image,
            'panoramic_image' => 'https://momento360.com/e/u/1139672d1f0c45c1afdd47a9143c51da?utm_campaign=embed&utm_source=other&heading=0&pitch=0&field-of-view=75&size=medium',
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'duration' => $this->faker->numberBetween(1, 127),
            'overview' => $this->faker->text,
            'included' => $this->faker->text,
            'additional' => $this->faker->text,
            'departure' => $this->faker->text,
            'status' => $this->faker->numberBetween(1, 2),
            'trending' => $this->faker->numberBetween(1, 2),
            'created_at' => time(),
            'updated_at' => time(),
        ];
    }
}
