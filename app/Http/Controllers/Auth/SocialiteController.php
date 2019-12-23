<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;

class SocialiteController extends Controller
{
    
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    /**
    * Obtain the user information from given provider.
    *
    * @return \Illuminate\Http\Response
    */public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();    // return the Laravel Passport access token response
        dd([$user, $provider]);
    }
}
