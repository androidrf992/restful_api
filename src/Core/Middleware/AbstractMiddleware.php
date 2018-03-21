<?php

namespace Core\Middleware;

/**
 * General middleware interface for using in Pipeline while action processing
 * @package Core\Middleware
 */
abstract class AbstractMiddleware
{
    /**
     * Executed method while action processing
     *
     * @param \Closure $next
     * @return mixed
     */
    abstract public function run(\Closure $next);

    public function __invoke(\Closure $next)
    {
        return $this->run($next);
    }
}
