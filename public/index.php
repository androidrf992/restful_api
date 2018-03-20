<?php

require_once __DIR__ . '/../src/autoload.php';

$routeCollection = require __DIR__ . '/../config/routes.php';
$container = require __DIR__ . '/../config/container.php';
session_start();
$request = \Core\Http\Request\Request::initByGlobals();
$routeHandler = new \Core\Route\RouteHandler($routeCollection);

$app = new \Core\App($request, $routeHandler, $container);
$app->run(
    $container->get(\Core\Sender\SenderInterface::class),
    $container->get(\Core\ActionRunner\ActionRunner::class)
);


