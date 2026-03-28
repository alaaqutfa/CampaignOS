<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckCompany
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user || !$user->company_id || $user->hasRole('super_admin')) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
