<?php

namespace Core;

use Core\Exceptions\ActionClassOrMethodNotExistException;
use Core\Exceptions\ActionMethodNotPublicException;
use Core\Exceptions\NotMatchedRouteActionException;
use Core\Exceptions\NotValidActionResultException;
use Core\Http\Response\ResponseInterface;
use Core\Route\RouteInterface;

class ActionRunner
{
    public function execute(RouteInterface $route): ResponseInterface
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

        $response = \call_user_func_array($actionCallback, $arguments);

        if (!$response instanceof ResponseInterface) {
            throw new NotValidActionResultException('expect ResponseInterface object');
        }

        return $response;
    }
}