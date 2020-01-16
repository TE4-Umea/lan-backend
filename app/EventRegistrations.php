<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventRegistrations extends Model
{
    protected $fillable = [
        'room_id',
        'group_code',
        'setup_type',
        'checked_in'
    ];
}
