<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'event_date',
        'start_time',
        'end_time',
        'image',
        'max_attendees',
        'organizer_id',
        'category_id',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'max_attendees' => 'integer',
        ];
    }

    // ========== RELATIONSHIPS ==========
    
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')
                    ->withTimestamps();
    }

    // ========== SCOPES (masih OK di model) ==========
    
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->toDateString())
                    ->where('status', 'published');
    }
}