<?php

namespace Core\Route;

use Core\Http\Request\RequestInterface;

/**
 * General tmethod for working with route in application
 * @package Core\Route
 */
interface RouteInterface
{
    public function match(RequestInterface $request): bool;

    public function getAction(): RouteActionInterface;

    public function setMiddleware(array $middlewares);

    public function setPrefix($prefix);

    public function hasMiddlewares(): bool;

    public function getMiddlewares(): array;
}
