<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use \Laravel\Passport\Http\Middleware\CheckClientCredentials;
use \App\Http\Middleware\SocialiteAuthenticate;

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
        if(!$request->filled('accessType')) {
            return app(CheckClientCredentials::class)->handle($request, function ($request) use ($next) {
                return $next($request);
            });
        }
        // authenticate with socialite
        return app(SocialiteAuthenticate::class)->handle($request, function ($request) use ($next) {
            return $next($request);
        });
        
    }
}
