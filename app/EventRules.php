<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventRules extends Model
{
    protected $fillable = [
        'body'
    ];
    public function events(){
        return $this->belongsToMany('App\Event');
    }
}
