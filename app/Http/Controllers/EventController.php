<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Event;

class EventController extends Controller
{
    public function store(Request $event){

        $validatedData = $event->validate([
            'title' => 'bail|required|max:32|string',
            'short_info' => 'bail|required|max:512|string',
            'rules_id' => 'bail|required|exists:event_rules,id',
            'start_date' => 'bail|required|date|after_or_equal:today',
            'end_date' => 'bail|required|date|after_or_equal:start_date',
            'registration_closes_at' => 'bail|required|date|before_or_equal:start_date'
        ]);

        $data = Event::create($validatedData);
        
        return [
            'message' => 'Event was created',
            'data' => $data
        ];//Success Page
    }

    public function show($id) {
        return Event::findOrFail($id);
    }
    
    public function latest() {
        return Event::latest('id')->firstOrFail();
    }

    public function destroy(){

    }
}