<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_approved',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'boolean',
        ];
    }

    // ========== RELATIONSHIPS ==========
    
    // User bisa punya banyak events (sebagai organizer)
    public function events()
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }

    // User bisa punya banyak orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // User bisa favorite banyak events
    public function favoriteEvents()
    {
        return $this->belongsToMany(Event::class, 'favorites')
                    ->withTimestamps();
    }
}