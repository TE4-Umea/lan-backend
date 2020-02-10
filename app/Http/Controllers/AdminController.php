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

    }

    public function store($id, Request $request) {

    }

    public function destroy($id, Request $request) {

    }
}
