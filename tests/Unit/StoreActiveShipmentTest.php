<?php

namespace Tests\Unit;

use Tests\TestCase;

class StoreActiveShipmentTest extends TestCase
{
    /**
     * Test a console command.
     *
     * @return void
     */
    public function test_active_shipment_command()
    {
        $this->artisan('active-shipments:store')
             ->expectsOutput('Storing active shipments')
             ->expectsOutput('Done storing active shipments')
             ->doesntExpectOutput('Error running command')
             ->assertExitCode(0);
    }


}
