<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'description',
        'price',
        'quantity_available',
        'quantity_sold',
        'sales_start',
        'sales_end',
        'max_per_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'quantity_available' => 'integer',
            'quantity_sold' => 'integer',
            'max_per_order' => 'integer',
            'sales_start' => 'datetime',
            'sales_end' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    // ========== RELATIONSHIPS ==========
    
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
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