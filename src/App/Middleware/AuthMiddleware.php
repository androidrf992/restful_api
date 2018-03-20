<?php

namespace App\Middleware;

use Core\Middleware\AbstractMiddleware;

class AuthMiddleware extends AbstractMiddleware
{
    public function run(\Closure $next)
    {
        return $next();
    }
}