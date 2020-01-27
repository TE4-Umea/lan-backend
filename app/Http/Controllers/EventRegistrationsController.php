<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EventRegistrations;
use Vinkla\Hashids\Facades\Hashids;
use App\Events\RegistrationUpdated;

class EventRegistrationsController extends Controller
{
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
    
   
    public function show(Request $request){
        $registration = collect(EventRegistrations::where('user_id', $request->user()->id)
        ->where('event_id', $request->route('id'))
        ->firstOrFail());
   
        $hashedId = Hashids::encode($registration['id']);
        $registration->put('hashid', $hashedId);
        return $registration;
    }
}