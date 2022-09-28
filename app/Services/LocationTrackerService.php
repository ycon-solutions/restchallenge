<?php 

namespace App\Services;

use Illuminate\Support\Facades\Http;

class LocationTrackerService {

	public function getPositionData() {

		$loc_api_key = config('location-tracker.LOCTRACKER_API_KEY');
		$loc_api_url = config('location-tracker.LOCTRACKER_API_URL');
		$request_url = "${loc_api_url}?key=${loc_api_key}";
		$response = Http::get($request_url);
		
		return $response['positions'];
	}
}