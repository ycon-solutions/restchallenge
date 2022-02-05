<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shipment extends Model
{
    use HasFactory;
    use Searchable;

    const SHIPMENT_STATUS_ACTIVE    = "ACTIVE";
    const SHIPMENT_STATUS_DELIVERED = "DELIVERED";

    protected $fillable = ['shipment_number', 'status', 'gpsdevice_id'];

    protected $searchableFields = ['*'];

    public function gpspositions()
    {
        return $this->hasMany(Gpsposition::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'ACTIVE');
    }
}
