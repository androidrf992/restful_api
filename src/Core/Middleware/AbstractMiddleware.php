<?php

namespace Core\Middleware;

abstract class AbstractMiddleware
{
    abstract public function run(\Closure $next);

    public function __invoke(\Closure $next)
    {
        return $this->run($next);
    }
}