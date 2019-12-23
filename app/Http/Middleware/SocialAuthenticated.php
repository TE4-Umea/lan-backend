<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
// use Laravel\Passport\Http\Middleware\CheckClientCredentials;
// use \Laravel\Passport\Http\Middleware\CheckClientCredentialsForAnyScope;
use \App\Http\Middleware\SocialiteAuthenticate;
use Illuminate\Auth\Middleware\Authenticate;

class SocialAuthenticated
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
        // if should be authenticated with passport
        if(!$request->filled('provider')) {            
            return app(Authenticate::class)->handle($request, function ($request) use ($next) {
                return $next($request);
            }, "api");
        }
        // authenticate with socialite
        return app(SocialiteAuthenticate::class)->handle($request, function ($request) use ($next) {
            return $next($request);
        });  
    }
}
