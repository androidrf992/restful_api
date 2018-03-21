<?php

use Core\ActionRunner\ActionRunner;
use Core\App;
use Core\Http\Request\Request;
use Core\Route\RouteHandler;
use Core\Sender\SenderInterface;

require_once __DIR__ . '/../src/autoload.php';
define('BASE_PATH', __DIR__ . '/../');

$routeCollection = require __DIR__ . '/../config/routes.php';
$container = require __DIR__ . '/../config/container.php';
$config = require __DIR__ . '/../config/config.php';
$container->set('config', $config);

$request = Request::initByGlobals();
$routeHandler = new RouteHandler($routeCollection);

$app = new App($request, $routeHandler, $container);
$app->run(
    $container->get(SenderInterface::class),
    $container->get(ActionRunner::class)
);
