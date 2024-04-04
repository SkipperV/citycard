<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransportRoute extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'route_number',
        'transport_type',
        'route_endpoint_1',
        'route_endpoint_2'
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
