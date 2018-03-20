<?php

namespace Core\Route;

use Core\Http\Request\RequestInterface;

class RouteCollection implements RouteCollectionInterface
{
    private $routeList = [];

    public function get(string $pattern, $action, array $patternArgs = []): RouteInterface
    {
        return $this->addRoute(RequestInterface::METHOD_GET, $pattern, $action, $patternArgs);
    }

    public function post(string $pattern, $action, array $patternArgs = []): RouteInterface
    {
        return $this->addRoute(RequestInterface::METHOD_POST, $pattern, $action, $patternArgs);
    }

    public function put(string $pattern, $action, array $patternArgs = []): RouteInterface
    {
        return $this->addRoute(RequestInterface::METHOD_PUT, $pattern, $action, $patternArgs);
    }

    public function delete(string $pattern, $action, array $patternArgs = []): RouteInterface
    {
        return $this->addRoute(RequestInterface::METHOD_DELETE, $pattern, $action, $patternArgs);
    }

    private function addRoute(string $method, string $pattern, $action, $patternArgs): RouteInterface
    {
        $route = new Route($method, [$pattern, $patternArgs], $action);
        $this->routeList[] = $route;

        return $route;
    }

    public function getRoutes(): array
    {
        return $this->routeList;
    }
}