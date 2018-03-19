<?php

namespace Core;

use Core\Http\Request\Request;
use Core\Http\Response\ResponseInterface;
use Core\Route\Router;
use Core\Sender\SenderInterface;

class App
{
    private $request;

    private $router;

    public function __construct(Request $request, Router $router)
    {
        $this->request = $request;
        $this->router = $router;
    }

    public function run(SenderInterface $sender, ResponseInterface $response)
    {
        $sender->send($response);
    }
}