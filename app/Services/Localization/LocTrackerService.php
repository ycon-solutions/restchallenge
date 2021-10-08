<?php

namespace App\Services\Localization;

use Illuminate\Support\Facades\Http;

/**
 * Implementation of the LocatizationTrackerInterface for locTracker REST API
 * 
 * https://mail-attachment.googleusercontent.com/attachment/u/0/?ui=2&ik=155b9e07d6&attid=0.1&permmsgid=msg-f:1712950757423265912&th=17c59fa365f33878&view=att&disp=inline&sadnir=1&saddbat=ANGjdJ8qoVmtPkK2_oV8CQojCnsIeI1ugwlSBojQDBsybaQfAQ5RQYdcv_AVXZ-SyGEvpk-VfllWMYN3gC6Jo4L8sGLQQhCg0ltmAXX8zpP3mnpQGW1rp2IODmvHtBmaoG_IfTvgB1Y0W1YXC4Egkbe0sU7ZdS5oLMy7rV13OBiIWQqDfIVgil2Y6KiEn5mDGQcdOUlBc4KhDVuEZ2JXZpuR8zIaOr0GL4zul0s6_ExkAd7_uaYRFeOS07_LBDywwuEtqea9Sxvy8nt8_T-i2s7h_L0TA3PSQYvzm0wgOtDSCzlXUqT9guSx0PLE1m1mrgq-Xwkq6_BhrOvh4POdedKyWcVVirO5PywJwkGQ8NQvbKM8orkbiQxzAdroDhQXDUajorLzQHLpp-aNDSc7hdU0aXBofqdFgIO1rlg96QsccxnSHbvryqvI7cYCyDUVq3xAlc07DvzSgG4jDNJVwnwuzdzg4rY6WQay1Y-OG7zHbiJ9lsyy82w2ffG9aS2XcxALppcESy7IYfypXACz4UkFoqjO_mEQ5Pq8h4oocbFaysKd64dXxDFh9IwfOf8RZWucPVXJPp_-yLZ5RKbYnKHGSCwWhAq4436UK14ASKbrMke-ueOEPFRbmnX9jFPJGl9bF16E_IC7jDW4W8-gXa18dBjUblU__S8X2vS5Pr7VXdOaRWF2Xhz5WoxBVxM
 */
class LocTrackerService implements LocalizationTrackerInterface
{
    private string $_key;
    private string $_url;
    private string $_action;

    public function __construct()
    {
        $this->_key = env('LOCTRACKER_API_KEY');
        $this->_url = env('LOCTRACKER_API_URL');
        $this->_action = 'positions';
    }

    /**
     * Gets all locatizations of the objects registered on the api service
     * 
     * @return array
     */
    public function all(): array
    {
        $response = Http::get($this->_url . $this->_action, ['key' => $this->_key]);

        $result = $response->json();

        if (array_key_exists($this->_action, $result)) {
            return $this->parse($result[$this->_action]);
        }

        return [];
    }

    /**
     * Get the localization of a object with a given ID
     * 
     * @param string $deviceId the ID of ther object to track
     * 
     * @return array an array with information about the localization of the object
     */
    public function byId(string $deviceId): array
    {
        $all = self::all();

        foreach ($all as $value) {
            if ($value['deviceId'] === $deviceId) {
                return $value;
            }
        }

        return null;
    }

    /**
     * Parses the positions arrays in a format ready 
     * to be complient with Ycon database.
     *
     * @param array $positions array of arrays specifying positions on Loctracker
     * 
     * @return array
     */
    protected function parse(array $positions): array
    {
        $required = [
            'lng' => 'longitude',
            'lat' => 'latitude',
            'time' => 'utc_timestamp',
            'deviceId' => 'gpsdevice_id'
        ];

        return array_map(
            function (array $position) use ($required) {
                // Make sure the position array has all the required keys
                if (count(array_intersect_key($required, $position)) === count($required)) {
                    $pos = [];
                    foreach ($required as $key => $value) {
                        $pos[$value] = $position[$key];
                    }

                    // Because the timestamp comes in microseconds
                    $pos['utc_timestamp'] = date('Y-m-d H:i:s', $pos['utc_timestamp'] / 1000);

                    return $pos;
                }
            },
            $positions
        );
    }
}
