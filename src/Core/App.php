<?php

namespace Core;

use Core\Http\Request\Request;
use Core\Http\Response\Response;
use Core\Route\Router;

class App
{
    private $request;

    private $router;

    public function __construct(Request $request, Router $router)
    {
        $this->request = $request;
        $this->router = $router;
    }

    public function run(ResponseSender $sender, Response $response)
    {
        $sender->send($response);
    }
}