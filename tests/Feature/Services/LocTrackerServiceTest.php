<?php

namespace Tests\Feature\Services;

use App\Services\Localization\LocTrackerService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LocTrackerServiceTest extends TestCase
{
    /** @test */
    public function it_returns_a_array_of_two_locations()
    {
        $url = env('LOCTRACKER_API_URL') . 'positions*';

        $loctracker = new LocTrackerService;

        Http::fake(
            [
                $url => Http::response(
                    json_decode(file_get_contents('tests/stubs/loctracker_positions_response.json'), true),
                    200
                )
            ]
        );

        $locations = $loctracker->all();

        $this->assertIsIterable($locations);
        $this->assertCount(2, $locations);

        foreach ($locations as $loc) {
            $this->assertArrayHasKey('longitude', $loc);
            $this->assertArrayHasKey('latitude', $loc);
            $this->assertArrayHasKey('utc_timestamp', $loc);
            $this->assertArrayHasKey('gpsdevice_id', $loc);
        }
    }
}
