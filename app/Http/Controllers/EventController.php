<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Event;

class EventController extends Controller
{
    public function create($event){
        
        Event::create([
            'title' => $event('title'),
            'short_info' => $event('short_info'),
            'rules_id' => $event('rules_id'),
            'start_date' => $event('start_date'),
            'end_date' => $event('end_date'),
            'registration_closes_at' => $event('registration_closes_at')
            ]);
        return view('welcome');
    }
    public function show(){

    }
    public function delete(){

    }
}