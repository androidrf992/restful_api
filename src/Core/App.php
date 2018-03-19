<?php

namespace Core;

use Core\Http\Request\Request;
use Core\Route\RouteHandler;
use Core\Sender\SenderInterface;

class App
{
    private $request;

    private $routeHandler;

    public function __construct(Request $request, RouteHandler $routeHandler)
    {
        $this->request = $request;
        $this->routeHandler = $routeHandler;
    }

    public function run(SenderInterface $sender)
    {
        $action = $this->routeHandler->handle($this->request);

        $sender->send($action());
    }
}