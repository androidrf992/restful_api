<?php

namespace Core\Route;

use Core\Http\Request\RequestInterface;

interface RouteInterface
{
    public function match(RequestInterface $request): bool;

    public function getAction();

    public function getParams(): array;
}