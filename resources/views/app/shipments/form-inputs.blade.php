@php $editing = isset($shipment) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.text
            name="status"
            label="Status"
            value="{{ old('status', ($editing ? $shipment->status : '')) }}"
            maxlength="255"
            placeholder="Status"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.text
            name="shipment_number"
            label="Shipment Number"
            value="{{ old('shipment_number', ($editing ? $shipment->shipment_number : '')) }}"
            maxlength="255"
            placeholder="Shipment Number"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="gpsdevice_id"
            label="Gpsdevice Id"
            value="{{ old('gpsdevice_id', ($editing ? $shipment->gpsdevice_id : '')) }}"
            maxlength="255"
            placeholder="Gpsdevice Id"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
