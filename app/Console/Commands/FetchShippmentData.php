<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\LocationTrackerService;

use App\Models\Gpsposition;
use App\Models\Shipment;
use Carbon\Carbon;

class FetchShippmentData extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shipmentposition';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Getting Shippment Position';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tracker   = new LocationTrackerService();
        $positions = $tracker->getPositionData();
        //$shipment = Shipment::where('status', 'ACTIVE')->first();

        if( !empty( $positions ) ) {

            foreach ($positions as $position ) {
               
               $shipment = Shipment::where('status', 'ACTIVE')->where('gpsdevice_id', $position['deviceId'] )->first();
               if( !empty( $shipment ) ) {

                   $gposition = new Gpsposition();
                   $gposition->longitude  = $position['lng'];
                   $gposition->latitude = $position['lat'];
                   $gposition->utc_timestamp = Carbon::parse($position['time'])->toDateTimeString();
                   $gposition->shipment_id = $shipment->id;
                   $gposition->save();

               }

            }             
        }
    }
}
