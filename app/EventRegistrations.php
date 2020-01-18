<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventRegistrations extends Model
{
    protected $table = "registrations";
    
    protected $fillable = [
        'user_id',
        'room_id',
        'group_code',
        'setup_type',
        'checked_in'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
