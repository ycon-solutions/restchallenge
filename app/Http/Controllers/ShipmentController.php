<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;
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
            ->paginate(5);

        return view('app.shipments.index', compact('shipments', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Shipment::class);

        return view('app.shipments.create');
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

        return redirect()
            ->route('shipments.edit', $shipment)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Shipment $shipment
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Shipment $shipment)
    {
        $this->authorize('view', $shipment);

        return view('app.shipments.show', compact('shipment'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Shipment $shipment
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Shipment $shipment)
    {
        $this->authorize('update', $shipment);

        return view('app.shipments.edit', compact('shipment'));
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

        return redirect()
            ->route('shipments.edit', $shipment)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('shipments.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
