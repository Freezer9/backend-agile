<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyFastApiKey
{
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = config('app.fast_api_key');

        $apiKeyIsValid = (
            ! empty($apiKey)
            && $request->header('x-api-key') == $apiKey
        );

        abort_if (! $apiKeyIsValid, 403, 'Access denied');

        return $next($request);
    }
}
