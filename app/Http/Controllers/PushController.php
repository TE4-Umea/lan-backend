<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Notifications\PushNotification;
use Illuminate\Support\Facades\Notification;
use App\User;
use App\Notification as EventNotification;

class PushController extends Controller
{
    public function store(Request $request) {
        $this->validate($request,[
            'endpoint'    => 'required',
            'keys.auth'   => 'required',
            'keys.p256dh' => 'required'
        ]);
        $user = $request->user();
        $user->updatePushSubscription(
            $request->endpoint, 
            $request->keys['p256dh'], 
            $request->keys['auth']
        );
        
        return [
            'message' => 'Success',
        ];
    }

    public function push() {
        $data = EventNotification::first();
        Notification::send(User::all(), new PushNotification($data));
        return [
            'message' => 'Notification successfully sent'
        ];
    }
}