<?php

namespace Core\Route;

use Core\Http\Request\RequestInterface;

class RouteCollection implements RouteCollectionInterface
{
    private $routeList = [];

    public function get(string $pattern, $action, array $paramsRule = [])
    {
        $this->routeList[] = new Route(RequestInterface::METHOD_GET, $pattern, $action, $paramsRule);
    }

    public function post(string $pattern, $action, array $paramsRule = [])
    {
        $this->routeList[] = new Route(RequestInterface::METHOD_POST, $pattern, $action, $paramsRule);
    }

    public function put(string $pattern, $action, array $paramsRule = [])
    {
        $this->routeList[] = new Route(RequestInterface::METHOD_PUT, $pattern, $action, $paramsRule);
    }

    public function delete(string $pattern, $action, array $paramsRule = [])
    {
        $this->routeList[] = new Route(RequestInterface::METHOD_DELETE, $pattern, $action, $paramsRule);
    }

    public function getRoutes(): array
    {
        return $this->routeList;
    }
}