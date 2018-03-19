<?php

require_once __DIR__ . '/../src/autoload.php';

session_start();
$request = \Core\Http\Request\Request::initByGlobals();
$router = new \Core\Route\Router();

$app = new \Core\App($request, $router);
$sender = new \Core\ResponseSender();
$response = new \Core\Http\Response\Response('dasdasdassda');
$app->run(new \Core\ResponseSender(), $response);


