<?php

$collection = new \Core\Route\RouteCollection();

$collection->get('/', function () {
    return new \Core\Http\Response\JsonResponse(['status' => 'get']);
})->setMiddleware([\App\Middleware\EchoMiddleware::class]);

$collection->post('/', function () {
    return new \Core\Http\Response\JsonResponse(['status' => 'post']);
});

$collection->get('/user/{user_id}/{partner_id}/test', [
    'controller' => \App\Controller\SimpleController::class,
    'action' => 'paramAction'
], ['user_id' => 'd{2}', 'partner_id' => 'd{5}']);

$collection->post('/controller', [
    'controller' => \App\Controller\SimpleController::class,
    'action' => 'indexAction'
]);

$collection->delete('/html', function () {
    return new \Core\Http\Response\Response('delete html');
});


$collection->group(function (\Core\Route\RouteCollection $collection) {
    $collection->get('/hello', function () {
        return new \Core\Http\Response\Response('group-hello');
    });
    $collection->get('/bye', function () {
        return new \Core\Http\Response\Response('group-bye');
    });
    return $collection;
})->withPrefix('/api')->withMiddlewares([\App\Middleware\EchoMiddleware::class]);

return $collection;