<?php

namespace Database\Factories;

use App\Models\Gpsposition;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class GpspositionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Gpsposition::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'longitude' => $this->faker->randomNumber(2),
            'latitude' => $this->faker->randomNumber(2),
            'utc_timestamp' => $this->faker->dateTime,
            'shipment_id' => \App\Models\Shipment::factory(),
        ];
    }
}
