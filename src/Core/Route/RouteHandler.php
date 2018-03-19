<?php

namespace Core\Route;

use Core\Http\Request\RequestInterface;
use Core\Route\Exceptions\RouteNotMatchedException;

class RouteHandler
{
    private $routeCollection;

    public function __construct(RouteCollectionInterface $routeCollection)
    {
        $this->routeCollection = $routeCollection;
    }

    public function handle(RequestInterface $request)
    {
        /** @var Route $route */
        foreach ($this->routeCollection->getRoutes()  as $route) {
            if ($route->match($request)) {
                return new RouteHandlerResponse(
                    $route->getAction(),
                    $route->getParams()
                );
            }
        }

        throw new RouteNotMatchedException('Action not matched');
    }
}