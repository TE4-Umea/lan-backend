<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Notification;
use Notification as SendingNotification;
use App\Events\NotificationCreated;
use App\Http\Controllers\PushController;
use App\User;
use App\Notifications\PushNotification;
use App\EventRegistrations;

class EventNotificationsController extends Controller
{
    public function store(Request $notification ){
        $validatedData = $notification->validate([
            'title' => 'bail|required|max:32|string',
            'body' => 'bail|required|max:255|string',
            'event_id' => 'bail|required|integer',    
        ]);
        $data = Notification::create($validatedData);
        NotificationCreated::dispatch($data);
        
        $users = EventRegistrations::where('event_id', '=',  $validatedData['event_id'])
            ->where('checked_in', '=', 1)
            ->with('user')
            ->get()
            ->pluck('user')
            ->flatten();
        SendingNotification::send($users, new PushNotification($data));

        return [
            'message' => 'Event was created',
            'data' => $data
        ];
    }

    public function show(Event $event) {
        return $event->notifications()->get();
    }
    
    public function destroy(Event $event) {
        $event->notifications()->delete();
    }
}
