<?php

$collection = new \Core\Route\RouteCollection();

$collection->get('/', function () {
    return new \Core\Http\Response\JsonResponse(['status' => 'get']);
});

$collection->post('/', function () {
    return new \Core\Http\Response\JsonResponse(['status' => 'post']);
});

$collection->delete('/html', function () {
    return new \Core\Http\Response\Response('delete html');
});


return $collection;