<?php

namespace App\Http\Middleware;

use App\Traits\ResponseApi;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    use ResponseApi;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if(!auth()->check() || auth()->user()->role !== $role) {
            return $this->forbidden();
        }

        return $next($request);
    }
}
