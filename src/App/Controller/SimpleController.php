<?php

namespace App\Controller;

use Core\Http\Response\JsonResponse;
use Core\Http\Response\ResponseInterface;

class SimpleController
{
    public function indexAction(): ResponseInterface
    {
        return new JsonResponse(['status' => 'ok', 'response' =>'success']);
    }
}