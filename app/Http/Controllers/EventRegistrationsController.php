<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EventRegistrations;
use Vinkla\Hashids\Facades\Hashids;
use App\Events\RegistrationUpdated;

class EventRegistrationsController extends Controller
{
    public function index(Event $event){
        return $event->registrations;
    }

    public function store(Request $request){
        $validatedRegistration = $request->validate([
            'event_id' => 'required',
            'group_code' => 'nullable|alpha_dash',
            'guardian' => 'nullable|max:32',
            'setup_type' => 'required',
        ]);

        $data = collect(EventRegistrations::create([
            'user_id' => $request->user()->id,
            'event_id' => $validatedRegistration['event_id'],
            'guardian' => $validatedRegistration['guardian'],
            'group_code' => $validatedRegistration['group_code'],
            'setup_type' => $validatedRegistration['setup_type']
        ]));
        
        $hashedId = Hashids::encode($data['id']);
        $data->put('hashid', $hashedId);
        return [
            'message' => 'Registration successful',
            'data' => $data
        ];
    }

    public function update($hashid) {
        $id = Hashids::decode($hashid);

        EventRegistrations::where('id', $id)->update(['checked_in'=> 1]);
        $data = EventRegistrations::where('id', $id)->first();
        RegistrationUpdated::dispatch($data);
        return [
            'message' => 'Registration successful',
            'data' => $data
        ];
    }
    
   
    public function show(Request $request, $event){
        $registration = EventRegistrations::where('user_id', $request->user()->id)
        ->where('event_id', $event)
        ->firstOrFail();

        $collection = collect($registration);
        
        
        $collection->put('hashid', Hashids::encode($collection['id']));
        $collection->put('room', $registration->room);
        return $collection;
    }

}