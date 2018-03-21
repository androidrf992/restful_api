<?php

namespace Core\Route;

/**
 * Class for modifying collection routes
 * @package Core\Route
 */
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

    /**
     * Set prefix which use all routes in group
     *
     * @param string $prefix
     * @return RouteCollectionGroup
     */
    public function withPrefix(string $prefix): self
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * * Set middlewares which use all routes in group
     *
     * @param array $middlewares
     * @return RouteCollectionGroup
     */
    public function withMiddlewares(array $middlewares): self
    {
        $this->middlewares = $middlewares;

        return $this;
    }

    /**
     * Return modified routes
     *
     * @return array
     */
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
