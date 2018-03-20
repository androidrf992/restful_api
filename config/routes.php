<?php

use App\Controller\SimpleController;
use App\Middleware\EchoMiddleware;
use Core\Http\Response\JsonResponse;
use Core\Http\Response\Response;
use Core\Route\RouteCollection;

$collection = new RouteCollection();

$collection->get('/', function () {
    return new JsonResponse(['status' => 'get']);
})->setMiddleware([EchoMiddleware::class]);

$collection->post('/', function () {
    return new JsonResponse(['status' => 'post']);
});

$collection->get('/user/{user_id}/{partner_id}/test', [
    'controller' => SimpleController::class,
    'action' => 'paramAction'
], ['user_id' => 'd{2}', 'partner_id' => 'd{5}']);

$collection->post('/controller', [
    'controller' => SimpleController::class,
    'action' => 'indexAction'
]);

$collection->delete('/html', function () {
    return new Response('delete html');
});


$collection->group(function (RouteCollection $collection) {
    $collection->get('/hello', function () {
        return new Response('group-hello');
    });
    $collection->get('/bye', function () {
        return new Response('group-bye');
    });
    return $collection;
})->withPrefix('/api')->withMiddlewares([EchoMiddleware::class]);

return $collection;
