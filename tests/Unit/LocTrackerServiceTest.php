<?php

namespace Tests\Unit;

use App\Models\Shipment;
use App\Services\LocTracker\LocTrackerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;


class LocTrackerServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $api;
    protected $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->api = config('values.api');
        $this->url = config('values.url');
    }

    /** @test */
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
        $service = new LocTrackerService();
        $positions = $service->getPositionData();

        $this->assertIsArray($positions, "returns an array of device positions");
        $this->assertArrayHasKey('status', $positions);
        $this->assertArrayHasKey('positions', $positions);
        $this->assertArrayHasKey('key', $positions);
    }


}
