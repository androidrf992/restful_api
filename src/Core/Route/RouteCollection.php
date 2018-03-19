<?php

namespace Core\Route;

use Core\Http\Request\RequestInterface;

class RouteCollection implements RouteCollectionInterface
{
    private $routeList = [];

    public function get(string $pattern, $action, array $paramsRule = [])
    {
        $this->routeList[] = new Route(RequestInterface::METHOD_GET, $pattern, $action);
    }

    public function post(string $pattern, $action, array $paramsRule = [])
    {
        $this->routeList[] = new Route(RequestInterface::METHOD_POST, $pattern, $action);
    }

    public function put(string $pattern, $action, array $paramsRule = [])
    {
        $this->routeList[] = new Route(RequestInterface::METHOD_PUT, $pattern, $action);
    }

    public function delete(string $pattern, $action, array $paramsRule = [])
    {
        $this->routeList[] = new Route(RequestInterface::METHOD_DELETE, $pattern, $action);
    }

    public function getRoutes(): array
    {
        return $this->routeList;
    }
}