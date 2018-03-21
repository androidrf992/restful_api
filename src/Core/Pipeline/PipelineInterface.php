<?php

namespace Core\Pipeline;

use Core\Http\Response\ResponseInterface;
use Core\Middleware\AbstractMiddleware;

/**
 * Pipeline interface for working with middlewares
 *
 * @package Core\Pipeline
 */
interface PipelineInterface
{
    /**
     * Add middleware in queue
     *
     * @param AbstractMiddleware $middleware
     * @return mixed
     */
    public function add(AbstractMiddleware $middleware);

    /**
     * Run step by step all middleware
     *
     * @param \Closure $action
     * @return ResponseInterface
     */
    public function process(\Closure $action): ResponseInterface;
}
