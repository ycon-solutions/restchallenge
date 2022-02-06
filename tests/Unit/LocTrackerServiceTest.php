<?php

namespace Tests\Unit;

use App\Services\LocTracker\LocTrackerService;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;


class LocTrackerServiceTest extends TestCase
{
    protected $api;
    protected $url;
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->api = config('values.api');
        $this->url = config('values.url');

        $this->service = new LocTrackerService();

    }

    /**
     * @test
     */
    public function test_get_position_data()
    {
        $curl = $this->url.'/positions?key='.$this->api;
        Http::fake(
            [
                $curl => Http::response(
                    [
                        'key'=> 'APIKEY',
                        'status'=> 200,
                        'positions'=>
                            [
                                'lng'=> 22.44,
                                'lat'=> 2322.44,
                                'deviceId'=> 'MYDEVICE',
                                'time'=> 601285636589
                            ],
                        [
                            'lng'=> 1092.44,
                            'lat'=> 14322.44,
                            'deviceId'=> 'MYDEVICE2',
                            'time'=> 601286696589
                        ]
                    ],
                    200
                )
            ]
        );

        $positions = $this->service->getPositionData();

        $this->assertIsArray($positions, "returns an array of device positions");
        $this->assertArrayHasKey('status', $positions);
        $this->assertArrayHasKey('positions', $positions);
        $this->assertArrayHasKey('key', $positions);
    }

    /**
     * @test
     */
    public function test_maps_gpspositions_for_database()
    {
        $mappedData = $this->service->mapLocationData();

        $this->assertIsArray($mappedData, "returns an array of mapped positions");
        foreach ($mappedData as $data) {
            $this->assertArrayHasKey('gpsdevice_id', $data);
            $this->assertArrayHasKey('utc_timestamp', $data);
            $this->assertArrayHasKey('longitude', $data);
            $this->assertArrayHasKey('latitude', $data);
        }

    }

    /**
     * @test
     */
    public function test_saves_active_shipments()
    {
        $shipment = $this->service->saveActiveShipments();

        $this->assertNull($shipment, "returns void");

    }


}
