<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lauthz\Exceptions\UnauthorizedException;
use Lauthz\Facades\Enforcer;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$args): Response
    {
        if (Auth::guest()) {
            throw new UnauthorizedException();
        }

        $user = Auth::user();
        $identifier = $user->getAuthIdentifier();
        $identifier = strval($identifier);
        $routerName = $request->route()->getName();

        if (!Enforcer::enforce($identifier, $routerName, 'own') && !$user->isSuperAdmin()) {
            throw new UnauthorizedException();
        }

        return $next($request);
    }
}
