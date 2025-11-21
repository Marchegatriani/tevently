<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Favorite extends Pivot
{
    protected $table = 'favorites';

    public $incrementing = true;

    protected $fillable = [
        'user_id',
        'event_id',
    ];
}