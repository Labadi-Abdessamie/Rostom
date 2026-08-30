<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHTTPS
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isSecure()) {
            // HTTPS is already in use
            return $next($request);
        }

        // In production, always redirect to HTTPS
        if (env('APP_ENV') === 'production') {
            return redirect()->secure($request->getRequestUri());
        }

        // In development, allow HTTP but log warning
        if (env('APP_DEBUG', false)) {
            // Log the HTTP request for debugging
            logger()->warning('Request made over HTTP in development mode.', [
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
            ]);
        }

        return $next($request);
    }
}