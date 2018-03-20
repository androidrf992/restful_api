<?php

namespace Core;

use Core\Container\AppContainer;
use Core\Http\Request\Request;
use Core\Http\Request\RequestInterface;
use Core\Pipeline\PipelineInterface;
use Core\Route\Exceptions\RouteNotMatchedException;
use Core\Route\RouteHandler;
use Core\Sender\SenderInterface;
use Core\ActionRunner\ActionRunner;

class App
{
    private $request;

    private $routeHandler;

    private $container;

    public function __construct(Request $request, RouteHandler $routeHandler, AppContainer $container)
    {
        $container->set(RequestInterface::class, $request);
        $this->request = $request;
        $this->routeHandler = $routeHandler;
        $this->container = $container;
    }

    public function run(SenderInterface $sender, ActionRunner $runner)
    {
        try {
            $route = $this->routeHandler->handle($this->request);
            $response = $runner->execute(
                $route,
                $this->container->get(PipelineInterface::class)
            );
        } catch (RouteNotMatchedException $e) {
            $response = $this->container->get('response.method_not_allowed');
        } catch (\Exception $e) {
            $response = $this->container->get('response.general_error');
        }
        $sender->send($response);
    }
}