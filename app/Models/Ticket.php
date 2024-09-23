<?php

namespace App\Models;

use App\Enums\TicketType;
use App\Enums\TransportType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'transport_type' => TransportType::class,
        'ticket_type' => TicketType::class,
    ];

    protected $fillable = [
        'transport_type',
        'ticket_type',
        'price'
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
