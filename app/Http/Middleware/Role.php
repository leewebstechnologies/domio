<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, mixed $role): Response
    {
        if ($request->user()->role !== $role) {
            return redirect('dashboard');
        }
        return $next($request);
    }
}
