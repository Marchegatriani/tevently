<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity_available',
        'quantity_sold',
        'sales_start',
        'sales_end',
        'max_per_order',
        'is_active',
        'event_id',
    ];

    protected $casts = [
        'quantity_available' => 'integer',
        'quantity_sold' => 'integer',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'sales_start' => 'datetime',
        'sales_end' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getRemainingAttribute()
    {
        return max(0, ($this->quantity_available ?? 0) - ($this->quantity_sold ?? 0));
    }

    public function getAvailabilityStatus()
    {
        if (! $this->is_active) {
            return 'Inactive';
        }

        if (($this->quantity_sold ?? 0) >= ($this->quantity_available ?? 0)) {
            return 'Sold out';
        }

        $remaining = $this->remaining;
        $threshold = max(5, (int) ceil(($this->quantity_available ?? 0) * 0.10));
        if ($remaining <= $threshold) {
            return 'Low stock';
        }

        return 'Available';
    }
}