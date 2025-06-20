<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class log extends Model
{
    protected $fillable = [
        'date',
        'time',
        'user_id',
        'module',
        'object_id',
        'change',
        'ip_address',
        'browser'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
