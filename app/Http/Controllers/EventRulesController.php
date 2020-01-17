<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EventRules;

class EventRulesController extends Controller
{
    public function update(Request $eventRules){
        return EventRules::updateOrCreate($eventRules->validate([
            'body' => 'bail|required|max:1024|string'
        ]));
    }
    
    public function show($id){
        return EventRules::findOrFail($id);
    }
}
