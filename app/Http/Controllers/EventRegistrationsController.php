<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EventRegistrations;

class EventRegistrationsController extends Controller
{
    public function store(Request $registration){
        $validatedRegistration = $registration->validate([
            'event_id' => 'required',
            'group_code' => 'alpha_dash',
            'setup_type' => 'required',
        ]);

        $data = EventRegistrations::create([
            'user_id' => $validatedRegistration->user()->id,
            'event_id' => $validatedRegistration->event_id,
            'group_code' => $validatedRegistration->group_code,
            'setup_type' => $validatedRegistration->setup_type
        ]);
        
        return [
            'message' => 'Registration successful',
            'data' => $data
        ];
    }

    public function show($id){
        return EventRegistrations::findOrFail($id);
    }

    public function latest()
    {
        
    }
    public function findEventRegistration(Request $request){
        // $x = Event::find($request->id)->first()->registrations()->where($request->user()->id)->first();
        return $registration = EventRegistrations::where('user_id', $request->user()->id)
        ->where('event_id', $request->id)
        ->firstOrFail();
    }
}
