<?php

use App\Controller\UserController;
use App\Middleware\AuthMiddleware;
use Core\Route\RouteCollection;

$collection = new RouteCollection();


$collection->group(function (RouteCollection $collection) {
    $collection->get('/users', [
        'controller' => UserController::class,
        'action' => 'listAction'
    ]);
    $collection->get('/users/{userId}', [
        'controller' => UserController::class,
        'action' => 'getAction'
    ], ['userId' => 'd+']);
    $collection->post('/users', [
        'controller' => UserController::class,
        'action' => 'createAction'
    ]);
    $collection->put('/users/{userId}', [
        'controller' => UserController::class,
        'action' => 'updateAction'
    ], ['userId' => 'd+']);
    $collection->delete('/users/{userId}', [
        'controller' => UserController::class,
        'action' => 'deleteAction'
    ], ['userId' => 'd+']);

    return $collection;
})->withPrefix('/api')->withMiddlewares([AuthMiddleware::class]);

$collection->post('/login', [
    'controller' => \App\Controller\AuthController::class,
    'action' => 'loginAction'
]);
$collection->post('/logout', [
    'controller' => \App\Controller\AuthController::class,
    'action' => 'logoutAction'
]);

return $collection;
