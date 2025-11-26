<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    // Add fillable/casts/relationships/helpers to match migration and controllers
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

    // Ticket belongs to an Event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Ticket has many Orders (used by controllers/views)
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Remaining tickets accessor
    public function getRemainingAttribute()
    {
        return max(0, ($this->quantity_available ?? 0) - ($this->quantity_sold ?? 0));
    }

    // Friendly availability status used in views
    public function getAvailabilityStatus()
    {
        if (! $this->is_active) {
            return 'Inactive';
        }

        if (($this->quantity_sold ?? 0) >= ($this->quantity_available ?? 0)) {
            return 'Sold out';
        }

        $remaining = $this->remaining;
        // low stock when remaining <= 10% or <= 5 items (adjust as needed)
        $threshold = max(5, (int) ceil(($this->quantity_available ?? 0) * 0.10));
        if ($remaining <= $threshold) {
            return 'Low stock';
        }

        return 'Available';
    }

    // ========== SCOPES ==========
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_active', true)
                    ->whereRaw('quantity_sold < quantity_available')
                    ->where('sales_start', '<=', now())
                    ->where('sales_end', '>=', now());
    }

    /**
 * Get available tickets for this event
 */
public function availableTickets()
{
    return $this->tickets()
        ->where('is_active', true)
        ->where('quota_remaining', '>', 0)
        ->where(function($query) {
            $query->whereNull('sales_start')
                  ->orWhere('sales_start', '<=', now());
        })
        ->where(function($query) {
            $query->whereNull('sales_end')
                  ->orWhere('sales_end', '>=', now());
        });
}

}