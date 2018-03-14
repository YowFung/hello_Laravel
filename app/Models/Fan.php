<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Fan extends Model
{
    use Notifiable;

    protected $fillable = [
        'from_id', 'to_id', 'read'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
