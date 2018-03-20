<?php

namespace Core\Route;

use Core\Http\Request\RequestInterface;

class RouteCollection implements RouteCollectionInterface
{
    private $routeList = [];

    public function get(string $pattern, $action, array $paramsRule = [])
    {
        $this->routeList[] = new Route(RequestInterface::METHOD_GET, [$pattern, $paramsRule], $action);
    }

    public function post(string $pattern, $action, array $paramsRule = [])
    {
        $this->routeList[] = new Route(RequestInterface::METHOD_POST, [$pattern, $paramsRule], $action);
    }

    public function put(string $pattern, $action, array $paramsRule = [])
    {
        $this->routeList[] = new Route(RequestInterface::METHOD_PUT, [$pattern, $paramsRule], $action);
    }

    public function delete(string $pattern, $action, array $paramsRule = [])
    {
        $this->routeList[] = new Route(RequestInterface::METHOD_DELETE, [$pattern, $paramsRule], $action);
    }

    public function getRoutes(): array
    {
        return $this->routeList;
    }
}