<?php

namespace App\Http\Middleware;

use Auth0\SDK\Helpers\JWKFetcher;
use Auth0\SDK\Helpers\Tokens\AsymmetricVerifier;
use Closure;
use Illuminate\Http\Request;
use Auth0\SDK\Helpers\Tokens\IdTokenVerifier;
use Illuminate\Support\Facades\Log;

class CheckAccess
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!empty(env('AUTH0_AUDIENCE')) && !empty(env('AUTH0_DOMAIN'))) {
            $token_issuer = env('AUTH0_DOMAIN');
            $jwks_fetcher = new JWKFetcher();
            $jwks = $jwks_fetcher->getKeys($token_issuer . '.well-known/jwks.json');
            $signature_verifier = new AsymmetricVerifier($jwks);
            $verifier = new IdTokenVerifier(
                env('AUTH0_DOMAIN'),
                env('AUTH0_AUDIENCE'),
                $signature_verifier
            );
            $token = $request->bearerToken();
            try {
                $decodedToken = $verifier->verify($token);
                if (!$decodedToken) {
                    abort(403,'Access denied');
                }
            } catch (\Exception $exception) {
                Log::error('Caught: Exception - ' . $exception->getMessage());
            }
        }

        return $next($request);
    }
}
