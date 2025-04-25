<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if ($request->user()->role !== $role) {
            return redirect()->route('frontend.index');
        } else {
            if (Auth::user()->status === "inactive") {
                Auth::logout();
                $notification = array(
                    'message' => 'Account Was inactive Please Contact Admin !',
                    'alert-type' => 'info'
                );
                return redirect()->route('frontend.index')->with($notification);
            } elseif (Auth::user()->status === "blocked") {
                Auth::logout();
                $notification = array(
                    'message' => 'Account Was blocked Please Contact Admin !',
                    'alert-type' => 'error'
                );
                return redirect()->route('frontend.index')->with($notification);
            } else {
                return $next($request);
            }
        }
    }
}

/*
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * /
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!in_array(Auth::user()->role, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
*/
