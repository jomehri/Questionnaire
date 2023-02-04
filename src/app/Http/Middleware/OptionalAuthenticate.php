<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class OptionalAuthenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            $this->authenticate($request, $guards);
        } catch(AuthenticationException $e) {
            /**
             * don't do anything as authentication is optional in this middleware
             */
        }

        return $next($request);
    }

}
