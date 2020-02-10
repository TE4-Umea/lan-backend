<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Notification;
use App\Notifications\PushNotification;
use App\User;
use App\PushSubscription;



class PushController extends Controller
{
    public function store(Request $request) {
        $this->validate($request,[
            'endpoint'    => 'required',
            'keys.auth'   => 'required',
            'keys.p256dh' => 'required'
        ]);

        $endpoint = $request->endpoint;
        $key = $request->keys['p256dh'];
        $user = $request->user();
        $user->updatePushSubscription($endpoint, $key);
        
        return [
            'message' => 'Success',
        ];
    }

    public function push() {
        Notification::send(User::all(), new PushNotification);
        return [
            'message' => 'Notification successfully sent',
        ];
    }
}