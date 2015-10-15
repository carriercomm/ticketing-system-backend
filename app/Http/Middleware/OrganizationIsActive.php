<?php

namespace App\Http\Middleware;

use Closure;

class OrganizationIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // API call to check that the organization's
        // subscription is still active.

        return $next($request);
    }
}
