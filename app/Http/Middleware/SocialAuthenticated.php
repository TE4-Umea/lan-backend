<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        if(!(strlen($request->header('provider')) > 0)) {            
            return app(Authenticate::class)->handle($request, function ($request) use ($next) {
                return $next($request);
            }, "api");
        }
        
        return app(SocialiteAuthenticate::class)->handle($request, function ($request) use ($next) {
            return $next($request);
        });  
    }
}
