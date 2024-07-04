<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;


class AdminAuthenticate extends Authenticate
{
    public function handle($request, Closure $next, ...$guards): RedirectResponse
    {
        $guard = $guards[0] ?? 'admin';
        
        if (Auth::guard($guard)->check()) {
            return new RedirectResponse(route('/admin/panel'));
        }

        //return $next($request);
        return redirect()->route('admin.index');
    }

    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('admin.index');
    }
}
