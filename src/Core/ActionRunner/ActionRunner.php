<?php

namespace Core\ActionRunner;

use Core\ActionRunner\Exceptions\ActionClassOrMethodNotExistException;
use Core\ActionRunner\Exceptions\ActionMethodNotPublicException;
use Core\ActionRunner\Exceptions\NotMatchedRouteActionException;
use Core\ActionRunner\Exceptions\NotValidActionResultException;
use Core\Http\Response\ResponseInterface;
use Core\Pipeline\PipelineInterface;
use Core\Route\RouteInterface;

/**
 * Class ActionRunner use for getting response by matched route
 * @package Core\ActionRunner
 */
class ActionRunner
{
    /**
     * Return appication response by given route & pipeline
     *
     * @param RouteInterface $route
     * @param PipelineInterface $pipeline
     *
     * @throws ActionClassOrMethodNotExistException
     * @throws ActionMethodNotPublicException
     * @throws NotValidActionResultException
     * @throws NotMatchedRouteActionException
     *
     * @return ResponseInterface
     */
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
            $actionCallback = [new $className(), $classAction];
        } else {
            throw new NotMatchedRouteActionException('expect callable or controller array');
        }

        if ($route->hasMiddlewares()) {
            foreach ($route->getMiddlewares() as $middleware) {
                $pipeline->add(new $middleware);
            }
        }

        $actionCallback = function () use ($actionCallback, $arguments) {
            return \call_user_func_array($actionCallback, $arguments);
        };
        $response = $pipeline->process($actionCallback);

        if (!$response instanceof ResponseInterface) {
            throw new NotValidActionResultException('expect ResponseInterface object');
        }

        return $response;
    }
}
