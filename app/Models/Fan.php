<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Fan extends Model
{
    use Notifiable;

    protected $fillable = [
        'master_id', 'follow_id', 'created_at'
    ];

}
