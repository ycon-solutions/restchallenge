<?php

namespace Database\Factories;

use App\Models\Shipment;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Shipment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'shipment_number' => $this->faker->ean8(),
            'status' => $this->faker->randomElement([Shipment::SHIPMENT_STATUS_ACTIVE, Shipment::SHIPMENT_STATUS_DELIVERED]),
            'gpsdevice_id' => $this->faker->->bothify('?##??#')
        ];
    }
}
