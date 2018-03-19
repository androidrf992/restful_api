<?php

require_once __DIR__ . '/../src/autoload.php';

session_start();
$request = \Core\Http\Request\Request::initByGlobals();
$router = new \Core\Route\Router();

$app = new \Core\App($request, $router);
//$response = new \Core\Http\Response\Response('dasdasdassda', 504);
$response = new \Core\Http\Response\JsonResponse([423, 43, 23423, 4234], 504);
$app->run(new \Core\Sender\SimpleHtmlSender(), $response);


