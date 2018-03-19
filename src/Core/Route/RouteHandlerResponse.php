<?php

namespace Core\Route;

class RouteHandlerResponse
{
    private $action;

    private $params;

    public function __construct($action, array $params)
    {
        $this->action = $action;
        $this->params = $params;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}