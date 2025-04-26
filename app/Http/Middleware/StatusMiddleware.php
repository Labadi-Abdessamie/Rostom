<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StatusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->magasin_id === null) {
            return redirect()->route('vendor.magasin_create')->with('message', 'Create Your Magasin First');
        } else if ($request->user()->magasin->status === 'firstOpening') {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('frontend.index')->with('message', 'Your Magasin is not active, please contact admin');
        }
        return $next($request);
    }
}
