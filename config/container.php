<?php

use App\Helper\Hydrator;
use App\Repository\UserJsonFileRepository;
use App\Repository\UserRepository;
use App\Service\UserService;
use Core\ActionRunner\ActionRunner;
use Core\Container\AppContainer;
use Core\Http\Response\JsonResponse;
use Core\Http\Response\ResponseCode;
use Core\Pipeline\Pipeline;
use Core\Pipeline\PipelineInterface;
use Core\Sender\SenderInterface;
use Core\Sender\SimpleHtmlSender;

$container = new AppContainer();

//core bind
$container->set(PipelineInterface::class, function ($c) {
    return new Pipeline();
});

$container->set(SenderInterface::class, function ($c) {
    return new SimpleHtmlSender();
});

$container->set(ActionRunner::class, function ($c) {
    return new ActionRunner();
});

$container->set('response.general_error', function ($c) {
    return new JsonResponse(
        ['status' => 'error', 'message' => 'server error'],
        ResponseCode::INTERNAL_SERVER_ERROR
    );
});

$container->set('response.method_not_allowed', function ($c) {
    return new JsonResponse(
        ['status' => 'error', 'message' => 'method not allowed'],
        ResponseCode::METHOD_NOT_ALLOWED
    );
});

// custom bind
$container->set(UserService::class, function ($c) {
    return new UserService($c->get(UserRepository::class));
});

$container->set(UserRepository::class, function ($c) {
    return new UserJsonFileRepository(BASE_PATH . '/data/user.json');
});

$container->set(Hydrator::class, function ($c) {
    return new Hydrator();
});

return $container;
