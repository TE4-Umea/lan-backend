<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        return User::where('admin', 1)->get();
    }

    public function search(Request $request) {
        $lookup = '%' . strtoupper($request['query']) . '%';
        return User::where('admin', 0)
            ->where(function ($query) use($lookup) {
                $query->whereRaw("upper(name) LIKE '" . $lookup . "'")
                ->orWhere('email', 'LIKE', $lookup);
            })->get();
    }

    public function update(User $user, Request $request) {
        if($user->id == $request->user()->id) {
            return abort("Trying to add or remove yourself as admin is bad 🙄");
        }
        $user->update(['admin' => $request->admin]);
        //TODO: Add user broadcasting event informing client with new user data.
        return [
            "message" => 'Successfully updated user',
            "user" => $user
        ];
    }

    public function destroy($id, Request $request) {

    }
}
