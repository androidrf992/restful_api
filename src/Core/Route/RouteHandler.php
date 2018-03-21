<?php

namespace Core\Route;

use Core\Http\Request\RequestInterface;
use Core\Route\Exceptions\RouteNotMatchedException;

/**
 * Class for handle request with route
 * @package Core\Route
 */
class RouteHandler
{
    private $routeCollection;

    public function __construct(RouteCollectionInterface $routeCollection)
    {
        $this->routeCollection = $routeCollection;
    }

    /**
     * Get route which match with request
     *
     * @throws RouteNotMatchedException
     * @param RequestInterface $request
     * 
     * @return RouteInterface
     */
    public function handle(RequestInterface $request): RouteInterface
    {
        /** @var Route $route */
        foreach ($this->routeCollection->getRoutes() as $route) {
            if ($route->match($request)) {
                return $route;
            }
        }

        throw new RouteNotMatchedException('Action not matched');
    }
}
