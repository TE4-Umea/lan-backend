<?php

namespace App\Http\Middleware;

use Closure;
use Socialite;

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
        if($request->filled('accessType')) {
            $social_user = Socialite::driver($request->accessType)->stateless()->userFromToken($request->token);
            $user = User::firstOrFail()->where('email', $social_user->email);
            if ($user) {
                $request->merge(['user' => $user ]);
                return $next($request);
            }
        }
        return abort(401, "The Supplied token is invalid!");
    }
}
