<?php

namespace Core\Route;

class RouteAction implements RouteActionInterface
{
    private $action;

    private $arguments;

    /**
     * RouteAction constructor.
     * @param $action
     * @param $arguments
     */
    public function __construct($action, $arguments)
    {
        $this->action = $action;
        $this->arguments = $arguments;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getArguments()
    {
        return $this->arguments;
    }
}