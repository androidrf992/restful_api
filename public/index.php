<?php

require_once __DIR__ . '/../src/autoload.php';

$routeCollection = require __DIR__ . '/../config/routes.php';

session_start();
$request = \Core\Http\Request\Request::initByGlobals();
$routeHandler = new \Core\Route\RouteHandler($routeCollection);

$app = new \Core\App($request, $routeHandler);
$app->run(new \Core\Sender\SimpleHtmlSender(), new \Core\ActionRunner());


