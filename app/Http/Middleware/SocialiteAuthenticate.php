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
        try {
            $user = User::where('email', 
                Socialite::driver($request->header('provider'))
                    ->stateless()
                    ->userFromToken(
                        $request->bearerToken())['email'])->first();

            $request->setUserResolver(function () use ($user) {
                return $user;
            });
            
            if ($user) {
                return $next($request);
            }
        } catch (\Exception $e) {
            return abort(401, "Invalid Credentials");
        }
    }
}
