<?php

namespace Core\Route;

class RouteCollectionGroup
{
    /** @var RouteCollection */
    private $routeCollection;

    private $prefix;

    private $middlewares = [];

    public function __construct(\Closure $closure)
    {
        $routeCollection = new RouteCollection();
        $this->routeCollection = $closure($routeCollection);
    }

    public function withPrefix(string $prefix): self
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function withMiddlewares(array $middlewares): self
    {
        $this->middlewares = $middlewares;

        return $this;
    }

    public function getRoutes():array
    {
        $routes = $this->routeCollection->getRoutes();

        /** @var RouteInterface $route */
        foreach ($routes as &$route) {
            $route->setMiddleware($this->middlewares);
            $route->setPrefix($this->prefix);
        }

        return $routes;
    }
}
