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

/**
 * Main application
 * @package Core
 */
class App
{
    private $request;

    private $routeHandler;

    private static $container;

    public function __construct(Request $request, RouteHandler $routeHandler, AppContainer $container)
    {
        $container->set(RequestInterface::class, $request);
        $this->request = $request;
        $this->routeHandler = $routeHandler;
        self::$container = $container;
    }

    /**
     * Boot all app & execute request
     *
     * @param SenderInterface $sender
     * @param ActionRunner $runner
     */
    public function run(SenderInterface $sender, ActionRunner $runner)
    {
        try {
            $route = $this->routeHandler->handle($this->request);
            $response = $runner->execute(
                $route,
                App::container()->get(PipelineInterface::class)
            );
        } catch (RouteNotMatchedException $e) {
            $response = App::container()->get('response.method_not_allowed');
        } catch (\Exception $e) {
            $response = App::container()->get('response.general_error');
        }
        $sender->send($response);
    }

    /**
     * Get container for simple skipping frtom few layers
     *
     * @return AppContainer
     */
    public static function container(): AppContainer
    {
        return self::$container;
    }
}
