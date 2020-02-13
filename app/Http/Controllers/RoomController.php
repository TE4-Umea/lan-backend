<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\EventRegistrations;

class RoomController extends Controller
{
    public function store(Request $room) {
        $validatedData = $room->validate([
            'name' => 'bail|required|max:32|string',
            'max_capacity' => 'bail|required|integer' 
        ]);

        $data = Room::create($validatedData);

        return [
            'message' => 'Success',
            'data' => $data
        ];
    }

    public function show() {
        return Room::all();
    }
    
    public function update(Room $room, Request $req) {
        $data = $room->update($req->validate([
            'name' => 'bail|required|max:32|string',
            'max_capacity' => 'bail|required|integer' 
        ]));
        
        return [
            'message' => 'Success',
            'data' => $data
        ];
        
    }
    public function destroy(Room $room) {
        EventRegistrations::where('room_id', $room->id)->update(['room_id' => null]);
        return ["data" => $room->delete()];
    }
}
