<?php

namespace Core\Pipeline;

use Core\Http\Response\ResponseInterface;
use Core\Middleware\AbstractMiddleware;

interface PipelineInterface
{
    public function add(AbstractMiddleware $middleware);

    public function process(\Closure $action): ResponseInterface;
}
