<?php

namespace Core\Pipeline;

use Core\Http\Response\ResponseInterface;
use Core\Middleware\AbstractMiddleware;

class Pipeline implements PipelineInterface
{
    private $pipesList = [];

    public function add(AbstractMiddleware $middleware)
    {
        $this->pipesList[] = $middleware;
    }

    /**
     * Recursive running all middlewares
     *
     * @param \Closure $action
     * @return ResponseInterface
     */
    public function process(\Closure $action): ResponseInterface
    {
        $current = array_shift($this->pipesList);

        if ($current === null) {
            return $action();
        }

        return $current(function () use ($action) {
            return $this->process($action);
        });
    }
}
