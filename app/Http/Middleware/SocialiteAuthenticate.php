<?php

namespace App\Http\Middleware;

use Closure;
use Google_Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Socialite;
use App\User;

class SocialiteAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param bool $newToken
     * @return mixed
     */
    public function handle(Request $request, Closure $next, bool $newToken = false)
    {
        try {

            $user = User::where('email',
                Socialite::driver($request->header('Provider'))
                    ->stateless()
                    ->userFromToken(
                        $request->bearerToken())['email'])->first();

            $request->setUserResolver(function () use ($user) {
                return $user;
            });

            if ($user) {
                if($newToken) {
                    return $next($request)->header('Authorization', $request->bearerToken());
                }

                return $next($request);

            }
        } catch (\Exception $e) {
                $newToken = $this->refreshToken($request);
                if($newToken) {
                    Log::debug(\GuzzleHttp\json_encode($newToken, JSON_PRETTY_PRINT));
                    // $request->headers->set('Authorization', 'Bearer '. $newToken);
                    $request->headers->set('Authorization', 'Bearer ' . $newToken["access_token"]);
                    return $this->handle($request, $next, true);
                }
            return abort(401, "Invalid Credentials");
        }
    }

    private function refreshToken(Request $request)
    {
        $config = Config('services.google');

        // Set Client
        $client = new Google_Client;
        $client->setClientId($config['client_id']);
        $client->setClientSecret($config['client_secret']);
        $client->refreshToken($request->header('RefreshToken'));
        $client->setAccessType('offline');

        return $client->getAccessToken();
    }
}
