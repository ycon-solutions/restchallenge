<?php

namespace Database\Seeders;

use App\Models\Shipment;
use Illuminate\Database\Seeder;

class ShipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shipment::factory()->count(3)->create();

        Shipment::factory()->create([
            'gpsdevice_id' => 'NACNTX7E',
            'status' => Shipment::SHIPMENT_STATUS_ACTIVE
        ]);

        Shipment::factory()->count(9)->create();

    }
}
