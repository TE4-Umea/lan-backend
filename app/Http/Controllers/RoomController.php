<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function store(Request $room){
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

    public function show(){
        return Room::all();
    }
    
    public function update(Room $room, Request $req){
        $validatedData = $room->validate([
            'name' => 'bail|required|max:32|string',
            'max_capacity' => 'bail|required|integer' 
        ]);
        return $room->update($validatedData);
    }
}
