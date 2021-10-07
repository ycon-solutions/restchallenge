<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gpsposition extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'longitude',
        'latitude',
        'utc_timestamp',
        'shipment_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'utc_timestamp' => 'datetime',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
