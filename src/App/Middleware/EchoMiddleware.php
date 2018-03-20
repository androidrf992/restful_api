<?php

namespace App\Middleware;

use Core\Middleware\AbstractMiddleware;

class EchoMiddleware extends AbstractMiddleware
{
    public function run(\Closure $next)
    {
        var_dump(self::class);

        return $next();
    }
}