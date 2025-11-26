<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    // add fillable fields used by controller/database
    protected $fillable = [
        'user_id',
        'event_id',
        'ticket_id',
        'quantity',
        'total_tickets',
        'total_amount',
        'status',
        'order_number',
        'order_date',
        'expired_at',
    ];

    protected function casts(): array
    {
        return [
            'user_id'      => 'integer',
            'event_id'     => 'integer',
            'ticket_id'    => 'integer',
            'quantity'     => 'integer',
            'total_tickets' => 'integer',
            'total_amount' => 'decimal:2',
            'order_date'   => 'datetime',
            'expired_at'   => 'datetime',
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
    
    // Relation: order belongs to ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
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