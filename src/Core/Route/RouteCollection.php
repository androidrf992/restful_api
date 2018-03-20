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

    public function group(\Closure $closure): RouteCollectionGroup
    {
        $routeCollectionGroup = new RouteCollectionGroup($closure);
        $this->routeList[] = $routeCollectionGroup;

        return $routeCollectionGroup;
    }

    public function getRoutes(): array
    {
        $routes = [];
        foreach ($this->routeList as $item) {
            if ($item instanceof RouteCollectionGroup) {
                $routes = array_merge($routes, $item->getRoutes());
            } else {
                $routes[] = $item;
            }
        }

        return $routes;
    }

    private function addRoute(string $method, string $pattern, $action, $patternArgs): RouteInterface
    {
        $route = new Route($method, [$pattern, $patternArgs], $action);
        $this->routeList[] = $route;

        return $route;
    }
}
