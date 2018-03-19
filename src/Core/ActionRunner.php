<?php

namespace Core;

use Core\Exceptions\ActionControllerNotExistException;
use Core\Exceptions\ActionMethodNotExistException;
use Core\Exceptions\ActionMethodNotPublicException;
use Core\Exceptions\NotMatchedRouteActionException;
use Core\Exceptions\NotValidActionResultException;
use Core\Http\Response\ResponseInterface;

class ActionRunner
{
    public function execute($action): ResponseInterface
    {
        if (is_callable($action)) {
            $response = $action();
        } elseif (is_array($action) && isset($action['controller'], $action['action'])) {
            if (!class_exists($action['controller'])) {
                throw new ActionControllerNotExistException("Controller {$action['controller']} not exist");
            }
            $class = new $action['controller']();
            $classAction = $action['action'];
            if (!method_exists($class, $classAction)) {
                throw new ActionMethodNotExistException("Method {$classAction} not exist");
            }
            $reflection = new \ReflectionMethod($class, $classAction);
            if (!$reflection->isPublic()) {
                throw new ActionMethodNotPublicException('given method not public');
            }

            $response = $class->$classAction();
        } else {
            throw new NotMatchedRouteActionException('expect callable or controller array');
        }

        if (!$response instanceof ResponseInterface) {
            throw new NotValidActionResultException('expect ResponseInterface object');
        }

        return $response;
    }
}