<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory, Searchable;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'region'
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function transportRoutes(): HasMany
    {
        return $this->hasMany(TransportRoute::class);
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        if ($filters['search'] ?? false) {
            $query->where('name', 'like', '%' . request('search') . '%');
        }
    }
}
