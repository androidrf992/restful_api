<?php

namespace Core;

use Core\Exceptions\ActionClassOrMethodNotExistException;
use Core\Exceptions\ActionMethodNotPublicException;
use Core\Exceptions\NotMatchedRouteActionException;
use Core\Exceptions\NotValidActionResultException;
use Core\Http\Response\ResponseInterface;
use Core\Pipeline\PipelineInterface;
use Core\Route\RouteInterface;

class ActionRunner
{
    public function execute(RouteInterface $route, PipelineInterface $pipeline): ResponseInterface
    {
        $action = $route->getAction()->getAction();
        $arguments = $route->getAction()->getArguments();

        if (\is_callable($action)) {
            $actionCallback = $action;
        } elseif (\is_array($action) && isset($action['controller'], $action['action'])) {
            $className = $action['controller'];
            $classAction = $action['action'];
            try {
                $reflection = new \ReflectionMethod($className, $classAction);
            } catch (\ReflectionException $e) {
                throw new ActionClassOrMethodNotExistException($e->getMessage());
            }
            if (!$reflection->isPublic()) {
                throw new ActionMethodNotPublicException('given method not public');
            }
            $actionCallback = [$className, $classAction];
        } else {
            throw new NotMatchedRouteActionException('expect callable or controller array');
        }

        if ($route->hasMiddlewares()) {
            foreach ($route->getMiddlewares() as $middleware) {
                $pipeline->add($middleware);
            }
        }

        $actionCallback = function () use ($actionCallback, $arguments){
            return \call_user_func_array($actionCallback, $arguments);
        };
        $response = $pipeline->process($actionCallback);

        if (!$response instanceof ResponseInterface) {
            throw new NotValidActionResultException('expect ResponseInterface object');
        }

        return $response;
    }
}