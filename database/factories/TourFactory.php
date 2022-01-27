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
        $listImage = [
            'https://momento360.com/e/u/1139672d1f0c45c1afdd47a9143c51da?utm_campaign=embed&utm_source=other&heading=0&pitch=0&field-of-view=75&size=medium',
            'https://momento360.com/e/u/38595d79f3344837ba401f3524aff81c?heading=49.4&pitch=3.6&field-of-view=75& wheel=false&display-mode=clean',
            'https://momento360.com/e/uc/c9152676a29c43389a9d4b9ffb3a00fb?size=large&wheel=false&utm_campaign=marketingsite&utm_source=www&pan-speed=.035&reset-heading=true&display-mode=clean&autoplay-collection=true&ap-interval-coll=5&fade=400',
            'https://momento360.com/e/u/7700b958f28c426b84e2a17dd866615d?size=large&a-panel-controls=false&display-mode=clean_logo',
            'https://momento360.com/e/u/e7df2ba8d8524dbc8c142fa7549f838d?size=large&pan-speed=0&display-mode=clean_logo'
        ];
        $listVideo = ['5DBDd5qE2xM', 'UVbv-PJXm14', 'MMB2Vw9gtSo'];

        return [
            'name' => $name,
            'slug' => $slug,
            'destination_id' => $this->faker->randomElement($listDestination),
            'type_id' => $this->faker->randomElement($listType),
            'image' => $this->faker->image,
            'panoramic_image' => $this->faker->randomElement($listImage),
            'video' => $this->faker->randomElement($listVideo),
            'price' => $this->faker->randomFloat(2, 0, 1200),
            'duration' => $this->faker->numberBetween(1, 15),
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
