<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetTenant
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->company_id) {
            // Optionally set the current company in the container
            app()->instance('current_company', Auth::user()->company);
        }

        return $next($request);
    }
}
