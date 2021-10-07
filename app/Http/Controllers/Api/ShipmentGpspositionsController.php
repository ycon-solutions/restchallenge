<?php

namespace App\Http\Controllers\Api;

use App\Models\Shipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GpspositionResource;
use App\Http\Resources\GpspositionCollection;

class ShipmentGpspositionsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Shipment $shipment
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Shipment $shipment)
    {
        $this->authorize('view', $shipment);

        $search = $request->get('search', '');

        $gpspositions = $shipment
            ->gpspositions()
            ->search($search)
            ->latest()
            ->paginate();

        return new GpspositionCollection($gpspositions);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Shipment $shipment
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Shipment $shipment)
    {
        $this->authorize('create', Gpsposition::class);

        $validated = $request->validate([
            'longitude' => ['required', 'numeric'],
            'latitude' => ['required', 'numeric'],
            'utc_timestamp' => ['required', 'date'],
        ]);

        $gpsposition = $shipment->gpspositions()->create($validated);

        return new GpspositionResource($gpsposition);
    }
}
