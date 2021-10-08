<?php

namespace Tests\Feature\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class YconGPSPosTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function a_command_ycon_gpspos_exists()
    {
        $this->assertTrue(
            class_exists(\App\Console\Commands\YconUpdateGPSPos::class)
        );
    }

    /** @test */
    public function it_expects_default_status_active()
    {
        $this->_prepareTest();

        $this->artisan('ycon:gpspos')
            ->expectsOutput(
                'Getting GPS positions for all Shipments with status = ACTIVE'
            )
            ->expectsOutput(
                'Succefully imported the GPS positions for all Shipments with status = ACTIVE'
            );

        // Because just one of the Device ids returned on the request is on the database
        $this->assertDatabaseCount('gpspositions', 1);

        $this->assertDatabaseHas(
            'gpspositions',
            [
                "id" => "1",
                "longitude" => "7.22222",
                "latitude" => "48.11111",
                "utc_timestamp" => "2021-09-18 10:41:37",
                "shipment_id" => "4"
            ]
        );
    }

    /** @test **/
    public function it_updates_other_status_of_shipment()
    {
        $this->_prepareTest();

        $this->artisan('ycon:gpspos -S=DELIVERED');

        $this->assertDatabaseCount('gpspositions', 0);
    }

    private function _prepareTest()
    {
        $this->seed();
        $url = env('LOCTRACKER_API_URL') . 'positions*';

        Http::fake(
            [
                $url => Http::response(
                    json_decode(file_get_contents('tests/stubs/loctracker_positions_response.json'), true),
                    200
                )
            ]
        );
    }
}
