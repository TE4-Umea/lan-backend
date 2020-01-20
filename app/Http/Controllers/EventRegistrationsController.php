<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EventRegistrations;
use Vinkla\Hashids\Facades\Hashids;
class EventRegistrationsController extends Controller
{
    public function store(Request $request){
        $validatedRegistration = $request->validate([
            'event_id' => 'required',
            'group_code' => 'nullable|alpha_dash',
            'guardian' => 'nullable|max:32',
            'setup_type' => 'required',
        ]);

        $data = EventRegistrations::create([
            'user_id' => $request->user()->id,
            'event_id' => $validatedRegistration['event_id'],
            'guardian' => $validatedRegistration['guardian'],
            'group_code' => $validatedRegistration['group_code'],
            'setup_type' => $validatedRegistration['setup_type']
        ]);
        
        return [
            'message' => 'Registration successful',
            'data' => $data
        ];
    }

    public function latest()
    {
        
    }
    
    /*public function findEventRegistration(Request $request){
        // $x = Event::find($request->id)->first()->registrations()->where($request->user()->id)->first();
        return $request = EventRegistrations::where('user_id', $request->user()->id)
        ->where('event_id', $request->id)
        ->firstOrFail();
    }*/
    public function show(Request $request){
        // $x = Event::find($request->id)->first()->registrations()->where($request->user()->id)->first();
        return $request = EventRegistrations::where('user_id', $request->user()->id)
        ->where('event_id', $request->route('id'))
        ->firstOrFail();
        
        $hashedId = Hashids::encode($registration->id);
        $registration->put('hashid', $hashedId);
        return $registration;
    }
}