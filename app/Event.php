<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'id',
        'title',
        'short_info',
        'rules_id',
        'start_date',
        'end_date',
        'registration_closes_at'
    ];
}
