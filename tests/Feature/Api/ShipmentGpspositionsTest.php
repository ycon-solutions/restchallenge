<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Shipment;
use App\Models\Gpsposition;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShipmentGpspositionsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_shipment_gpspositions()
    {
        $shipment = Shipment::factory()->create();
        $gpspositions = Gpsposition::factory()
            ->count(2)
            ->create([
                'shipment_id' => $shipment->id,
            ]);

        $response = $this->getJson(
            route('api.shipments.gpspositions.index', $shipment)
        );

        $response->assertOk()->assertSee($gpspositions[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_shipment_gpspositions()
    {
        $shipment = Shipment::factory()->create();
        $data = Gpsposition::factory()
            ->make([
                'shipment_id' => $shipment->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.shipments.gpspositions.store', $shipment),
            $data
        );

        unset($data['longitude']);
        unset($data['latitude']);
        unset($data['utc_timestamp']);
        unset($data['shipment_id']);

        $this->assertDatabaseHas('gpspositions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $gpsposition = Gpsposition::latest('id')->first();

        $this->assertEquals($shipment->id, $gpsposition->shipment_id);
    }
    /**
     * @test
     */
    public function test_console_command()
    {
        $this->artisan('shipmentposition')->assertSuccessful();
    }
}
