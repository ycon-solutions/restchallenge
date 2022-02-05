<?php

namespace App\Services\LocTracker;

use App\Models\Gpsposition;
use App\Models\Shipment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Service to handle locTracker REST API
 * Since only one endpoint is needed, no 'Client' has to be created to handle other endpoints
 */
class LocTrackerService
{
    private $apiKey;
    private $url;

    public function __construct()
    {
        $this->apiKey = config('values.key');
        $this->url = config('values.url');
    }

    /**
     * Gets the positions of all connected devices from api
     * via the LocTracker api
     *
     * @return array
     */
    public function getPositionData(): array
    {
        $path = 'positions';
        $response = Http::get($this->url .'/'. $path, ['key' => $this->apiKey]);

        if ($response->status() !== 200) {
            return array();
        }

        return $response->json();

    }

    /**  Returns the shipment ID of an active device
     * @param string $deviceId ID of the GPS device
     *
     * @return int
     */
    public function getShipmentId(string $deviceId): int
    {
        $id = Shipment::select('id')->active()->where('gpsdevice_id', $deviceId)->first();
        return $id->id;
    }

    /**  Checks if the shipment is active by using the GPS device
     * @param string $deviceId ID of the GPS device
     *
     * @return bool
     */
    public function mapActiveShipment(string $deviceId): bool
    {
        $activeShipments = Shipment::select('id','gpsdevice_id')->active()->get()->toArray();
        $mapped = [];
        foreach ($activeShipments as $map) {
            $mapped[$map['gpsdevice_id']] = $map['id'];
        }

        if (isset($mapped[$deviceId])) {
            return true;
        }
        return false;
    }

    /**
     * Maps the positions data from endpoint to format of database table
     *
     * @return array
     */
    public function mapLocationData(): array
    {
        $result = $this->getPositionData();
        if (array_key_exists('positions', $result)) {
            $locationData = $result['positions'];

            $positions = [];
            foreach ($locationData as $data) {
                $positions[] = array(
                    'gpsdevice_id' => $data['deviceId'],
                    'utc_timestamp' => date('Y-m-d H:i:s', $data['time'] / 1000),
                    'longitude' => $data['lng'],
                    'latitude' => $data['lat'],
                );
            }
            return $positions;
        }

        return array();
    }

    /**  Save active shipments to database
     */
    public function saveActiveShipments()
    {
        //prepared collection from api new positions
        $collection = $this->mapLocationData();
        foreach ($collection as $item) {
            //check if active
            if ($this->mapActiveShipment($item['gpsdevice_id'])) {
                $position = new Gpsposition();
                $position->longitude = $item['longitude'];
                $position->latitude = $item['latitude'];
                $position->utc_timestamp = $item['utc_timestamp'];
                $position->shipment_id = $this->getShipmentId($item['gpsdevice_id']);
                $position->save();
            }
        }
    }

}
