<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventRegistrations extends Model
{
    protected $table = "registrations";
    
    protected $fillable = [
        'event_id',
        'user_id',
        'room_id',
        'guardian',
        'group_code',
        'setup_type',
        'checked_in'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function room()
    {
        return $this->hasOne('App\Room', 'id', 'room_id');
    }
}
