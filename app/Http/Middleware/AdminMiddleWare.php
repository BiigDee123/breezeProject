<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in AND is an admin
        if ($request->user() && $request->user()->is_admin) {
            return $next($request);
        }

        // Otherwise, abort with a 403 Forbidden error (or redirect)
        abort(403, 'Unauthorized access.');
    }
}
