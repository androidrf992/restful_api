<?php

namespace Core\Route;

use Core\Http\Request\RequestInterface;

interface RouteInterface
{
    public function match(RequestInterface $request): bool;

    public function getAction(): RouteActionInterface;

    public function withMiddleware(array $middlewares);

    public function hasMiddlewares(): bool;

    public function getMiddlewares(): array;
}