<?php

namespace Core;

use Core\Http\Request\Request;
use Core\Http\Response\JsonResponse;
use Core\Http\Response\ResponseCode;
use Core\Pipeline\Pipeline;
use Core\Route\Exceptions\RouteNotMatchedException;
use Core\Route\RouteHandler;
use Core\Sender\SenderInterface;
use Core\ActionRunner\ActionRunner;

class App
{
    private $request;

    private $routeHandler;

    public function __construct(Request $request, RouteHandler $routeHandler)
    {
        $this->request = $request;
        $this->routeHandler = $routeHandler;
    }

    public function run(SenderInterface $sender, ActionRunner $runner)
    {
        try {
            $route = $this->routeHandler->handle($this->request);
            $response = $runner->execute($route, new Pipeline());
        } catch (RouteNotMatchedException $e) {
            $response =  new JsonResponse(
                ['status' => 'error', 'message' => 'method not allowed'],
                ResponseCode::METHOD_NOT_ALLOWED
            );
        } catch (\Exception $e) {
            $response =  new JsonResponse(
                ['status' => 'error', 'message' => 'server error'],
                ResponseCode::INTERNAL_SERVER_ERROR
            );
        }
        $sender->send($response);
    }
}