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
        if($request->filled('provider')) {
            try {

                $social_user = Socialite::driver($request->provider)->
                    stateless()->
                    userFromToken($request->bearerToken());
            } catch (\Exception $e) {
                return abort(401, "Invalid Credentials");
            }
            // dd($social_user);
            $user = User::where('email', $social_user['email'])->first();
            $request->setUserResolver(function () use ($user) {
                return $user;
            });
            // dd($user);
            if ($user) {
                $request->merge(['user' => $user ]);
                return $next($request);
            }
        }
        return abort(401, "Invalid Credentials");
    }
}
