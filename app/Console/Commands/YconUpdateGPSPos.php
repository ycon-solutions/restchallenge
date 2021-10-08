<?php

namespace App\Console\Commands;

use App\Models\Gpsposition;
use App\Models\Shipment;
use App\Services\Localization\LocalizationTrackerInterface;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class YconUpdateGPSPos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ycon:gpspos 
                            {--S|status=ACTIVE : The status of the shipments}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches and updates the current GPS position 
        of all shipments in a given status.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(LocalizationTrackerInterface $loctracker)
    {
        parent::__construct();

        $this->loctracker = $loctracker;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $status = $this->option('status');

        $this->info(
            'Getting GPS positions for all Shipments with status = ' . $status
        );

        $positions = $this->loctracker->all();

        // In order to speed up the insertions and because normaly the
        // logs of a routine are not relevant, we disable them
        DB::disableQueryLog();

        foreach ($positions as $pos) {
            $this->_insertGPSPosition($pos, $status);
        }

        DB::enableQueryLog();

        $this->info(
            'Succefully imported the GPS positions for all Shipments with status = ' . $status
        );

        return 0;
    }

    /**
     * Get get shipment ID by gpsdevice_id. 
     *
     * @param string $status
     * @return int 
     */
    private function _getShipmentIdByDeviceId(string $deviceId, string $status): int|null
    {
        $id = DB::select(
            'SELECT id from shipments where status = "' . $status . '" and
             gpsdevice_id = "' . $deviceId . '" order by updated_at DESC LIMIT 1'
        );

        if (isset($id[0]) && property_exists($id[0], 'id')) {
            return $id[0]->id;
        }

        return null;
    }


    /**
     * Inserts a new record with the GPS position of the 
     * gpsdevice_id given on the $position array
     *
     * @param $position contains [longitude, latitude, utc_timestamp, gpsdevice_id]
     * 
     * @return boolean
     */
    private function _insertGPSPosition(array $position, string $status): bool
    {
        if ($shipmentId = $this->_getShipmentIdByDeviceId($position['gpsdevice_id'], $status)) {
            $attributes = array_merge($position, ['shipment_id' => $shipmentId]);
            $pos = new Gpsposition($attributes);

            return $pos->save();
        }


        return false;
    }
}
