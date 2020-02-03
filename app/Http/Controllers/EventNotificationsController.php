<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use App\Event;
use App\Events\NotificationCreated;

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

        return [
            'message' => 'Event was created',
            'data' => $data
        ];
    }

    public function show(Event $event) {
        return $event->notifications()->get();
    }
    
    public function destroy(Event $event) {
        $event->notifications()->delete;
    }
}
