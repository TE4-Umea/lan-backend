<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'short_info',
        'rules_id',
        'start_date',
        'end_date',
        'registration_closes_at'
    ];

    public function registrations() {
        return $this->hasMany('App\EventRegistrations');
    }

    public function rules(){
        return $this->hasOne('App\EventRules');
    }
}
