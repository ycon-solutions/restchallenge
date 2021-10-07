<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShipmentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => ['required', 'max:255', 'string'],
            'shipment_number' => ['required', 'max:255', 'string'],
            'gpsdevice_id' => ['required', 'max:255', 'string'],
        ];
    }
}
