<?php

$collection = new \Core\Route\RouteCollection();

$collection->get('/', function () {
    return new \Core\Http\Response\JsonResponse(['status' => 'get']);
});

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


return $collection;