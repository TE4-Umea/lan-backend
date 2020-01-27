<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;

class EventNotificationsController extends Controller
{
    public function store($notification){
        $validatedData = $notification->validate([
            'title' => 'bail|required|max:32|string',
            'body' => 'bail|required|max:255|string',
            'event_id' => 'bail|required|integer',    
        ]);
        Notification::create($validatedData);
    }

    public function show(){
        
    }
}
