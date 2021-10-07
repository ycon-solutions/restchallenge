<?php

namespace App\Http\Controllers\Api;

use App\Models\Shipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShipmentResource;
use App\Http\Resources\ShipmentCollection;
use App\Http\Requests\ShipmentStoreRequest;
use App\Http\Requests\ShipmentUpdateRequest;

class ShipmentController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Shipment::class);

        $search = $request->get('search', '');

        $shipments = Shipment::search($search)
            ->latest()
            ->paginate();

        return new ShipmentCollection($shipments);
    }

    /**
     * @param \App\Http\Requests\ShipmentStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShipmentStoreRequest $request)
    {
        $this->authorize('create', Shipment::class);

        $validated = $request->validated();

        $shipment = Shipment::create($validated);

        return new ShipmentResource($shipment);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Shipment $shipment
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Shipment $shipment)
    {
        $this->authorize('view', $shipment);

        return new ShipmentResource($shipment);
    }

    /**
     * @param \App\Http\Requests\ShipmentUpdateRequest $request
     * @param \App\Models\Shipment $shipment
     * @return \Illuminate\Http\Response
     */
    public function update(ShipmentUpdateRequest $request, Shipment $shipment)
    {
        $this->authorize('update', $shipment);

        $validated = $request->validated();

        $shipment->update($validated);

        return new ShipmentResource($shipment);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Shipment $shipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Shipment $shipment)
    {
        $this->authorize('delete', $shipment);

        $shipment->delete();

        return response()->noContent();
    }
}
