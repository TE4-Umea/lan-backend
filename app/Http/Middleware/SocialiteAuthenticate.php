<?php

namespace App\Http\Middleware;

use Closure;
use Socialite;
use App\User;

class SocialiteAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if($request->header('provider')) {
            try {

                $social_user = Socialite::driver($request->header('provider'))->
                    stateless()->
                    userFromToken($request->bearerToken());
            } catch (\Exception $e) {
                return abort(401, "Invalid Credentials");
            }
            
            $user = User::find($social_user['email']);
            $request->setUserResolver(function () use ($user) {
                return $user;
            });
            
            if ($user) {
                return $next($request);
            }
        }
        return abort(401, "Invalid Credentials");
    }
}
