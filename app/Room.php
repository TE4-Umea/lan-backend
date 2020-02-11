<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Room extends Model
{
    protected $fillable = [
        'name',
        'max_capacity'
    ];

    public function registrations()
    {
        return $this->hasMany('App\EventRegistrations');
    }
}
