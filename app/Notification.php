<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'title',
        'body',
        'event_id'
    ];

    public function event(){
        return $this->belongsTo('App\Event');
    }
}
