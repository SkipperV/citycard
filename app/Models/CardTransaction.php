<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardTransaction extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'transaction_type' => 'boolean',
        'created_at' => 'datetime:d-m-Y H:i:s'
    ];

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }
}
