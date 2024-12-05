<?php

namespace Database\Factories;

use App\Models\Influencer;
use Illuminate\Database\Eloquent\Factories\Factory;

class InfluencerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Influencer::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'instagram_handle' => $this->faker->paragraph,
            'followers_count'=> 155,
            'category_id' => 1,
        ];
    }
}
