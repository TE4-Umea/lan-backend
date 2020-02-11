<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\User;
use Illuminate\Support\Facades\Hash;

class PassportAuthController extends Controller
{

    public function login(Request $request)
    {
        $http = new \GuzzleHttp\Client;
        try {
            $response = $http->post(route('passport.token'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
                    'username' => $request->email,
                    'password' => $request->password,
                ]
            ]);
            return $response->getBody();
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            if ($e->getCode() === 400) {
                return response()->json('Invalid Request. Please enter a email or a password.', $e->getCode());
            } else if ($e->getCode() === 401) {
                return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
            }
            dd($e);
            // return abort($e->getCode(), 'Something went wrong on the server.');
        }
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        
        return User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            "student" => false,
            'password' => Hash::make($validatedData['password']),
        ]);
    }
    
    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return response()->json('Logged out successfully', 200);
    }
}
