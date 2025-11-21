<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'order_number',
        'total_amount',
        'total_tickets',
        'status',
        'order_date',
        'expired_at',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'total_tickets' => 'integer',
            'order_date' => 'datetime',
            'expired_at' => 'datetime',
        ];
    }

    // Auto generate order number
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(8));
            }
            
            if (empty($order->order_date)) {
                $order->order_date = now();
            }

            if ($order->status === 'pending' && empty($order->expired_at)) {
                $order->expired_at = now()->addHour();
            }
        });
    }

    // ========== RELATIONSHIPS ==========
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // ========== SCOPES ==========
    
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }
}