<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EventRules;

class EventRulesController extends Controller
{
    public function update(Request $request) {
        $validated = $request->validate([
            'id' => 'bail|required',
            'body' => 'bail|required|string'
        ]);
        return EventRules::updateOrCreate(['id' => $validated['id']], ['body' => $validated['body']]);
    }
    
    public function show($id) {
        return EventRules::findOrFail($id);
    }
}
