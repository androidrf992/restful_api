<?php

$container = new \Core\Container\AppContainer();

//core bind
$container->set(\Core\Pipeline\PipelineInterface::class, function ($c) {
   return new \Core\Pipeline\Pipeline();
});

$container->set(\Core\Sender\SenderInterface::class, function ($c) {
    return new \Core\Sender\SimpleHtmlSender();
});

$container->set(\Core\ActionRunner\ActionRunner::class, function ($c) {
    return new \Core\ActionRunner\ActionRunner();
});

$container->set('response.general_error', function ($c) {
    return new \Core\Http\Response\JsonResponse(
        ['status' => 'error', 'message' => 'server error'],
        \Core\Http\Response\ResponseCode::INTERNAL_SERVER_ERROR
    );
});

$container->set('response.method_not_allowed', function ($c) {
    return new \Core\Http\Response\JsonResponse(
        ['status' => 'error', 'message' => 'method not allowed'],
        \Core\Http\Response\ResponseCode::METHOD_NOT_ALLOWED
    );
});

return $container;