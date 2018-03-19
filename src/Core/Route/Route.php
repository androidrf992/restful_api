<?php

namespace Core\Route;

use Core\Http\Request\RequestInterface;

class Route implements RouteInterface
{
    protected $pattern;

    protected $action;

    protected $method;

    public function __construct(string $method, string $pattern, $action)
    {
        $this->method = $method;
        $this->action = $action;
        $this->pattern = $pattern;
    }

    public function match(RequestInterface $request): bool
    {
        return $this->method === $request ->getMethod()
            && $this->pattern === $request->getUri();
    }

    public function getAction()
    {
        return $this->action;
    }
}