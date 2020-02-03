<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Events\NewEventPublished;
use App\Event;

class EventController extends Controller
{
    public function store(Request $event) {

        $validatedData = $event->validate([
            'title' => 'bail|required|max:32|string',
            'short_info' => 'bail|required|max:512|string',
            'rules_id' => 'bail|required|exists:event_rules,id',
            'start_date' => 'bail|required|date|after_or_equal:today',
            'end_date' => 'bail|required|date|after_or_equal:start_date',
            'registration_closes_at' => 'bail|required|date|before_or_equal:start_date'
        ]);

        $data = Event::create([
            "title" => $validatedData['title'],
            "short_info" => $validatedData['short_info'],
            "rules_id" => $validatedData['rules_id'],
            "start_date"=> $this->parseDate($validatedData['start_date']),
            "end_date"=> $this->parseDate($validatedData['end_date']),
            "registration_closes_at"=> $this->parseDate($validatedData['registration_closes_at'])
            
        ]);

        NewEventPublished::dispatch($data);
        
        return [
            'message' => 'Event was created',
            'data' => $data
        ];//Success Page
    }
    protected function parseDate($date) {
        return Carbon::createFromFormat('Y-m-d\TH:i:s.uO', $date)->format('Y-m-d H:i');
    }
    public function show($id) {
        return Event::findOrFail($id);
    }
    
    public function latest() {
        return Event::latest('id')->firstOrFail();
    }

    public function destroy(Event $event) {
        $event->notifications()->delete;
        $event->registrations()->delete;
        $event->delete;

    }
}