<?php

namespace Core;

use Core\Exceptions\ActionClassOrMethodNotExistException;
use Core\Exceptions\ActionMethodNotPublicException;
use Core\Exceptions\NotMatchedRouteActionException;
use Core\Exceptions\NotValidActionResultException;
use Core\Http\Response\ResponseInterface;
use Core\Route\RouteHandlerResponse;

class ActionRunner
{
    public function execute(RouteHandlerResponse $handlerResponse): ResponseInterface
    {
        $action = $handlerResponse->getAction();
        $params = $handlerResponse->getParams();

        if (is_callable($action)) {
            $actionCallback = $action;
        } elseif (is_array($action) && isset($action['controller'], $action['action'])) {
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

        $response = call_user_func($actionCallback, $params);

        if (!$response instanceof ResponseInterface) {
            throw new NotValidActionResultException('expect ResponseInterface object');
        }

        return $response;
    }
}