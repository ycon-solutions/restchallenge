<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Shipment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShipmentTest extends TestCase
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
    public function it_gets_shipments_list()
    {
        $shipments = Shipment::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.shipments.index'));

        $response->assertOk()->assertSee($shipments[0]->shipment_number);
    }

    /**
     * @test
     */
    public function it_stores_the_shipment()
    {
        $data = Shipment::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.shipments.store'), $data);

        $this->assertDatabaseHas('shipments', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_shipment()
    {
        $shipment = Shipment::factory()->create();

        $data = [
            'shipment_number' => $this->faker->text(255),
            'status' => $this->faker->text(255),
            'gpsdevice_id' => $this->faker->text(255),
        ];

        $response = $this->putJson(
            route('api.shipments.update', $shipment),
            $data
        );

        $data['id'] = $shipment->id;

        $this->assertDatabaseHas('shipments', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_shipment()
    {
        $shipment = Shipment::factory()->create();

        $response = $this->deleteJson(
            route('api.shipments.destroy', $shipment)
        );

        $this->assertDeleted($shipment);

        $response->assertNoContent();
    }
}
