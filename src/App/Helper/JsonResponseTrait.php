<?php

namespace App\Helper;

use Core\Http\Response\JsonResponse;
use Core\Http\Response\ResponseInterface;

trait JsonResponseTrait
{
    public function successJsonResponse($response): ResponseInterface
    {
        return new JsonResponse(['status' => 'ok', 'response' => $response]);
    }

    public function errorJsonResponse($message): ResponseInterface
    {
        return new JsonResponse(['status' => 'error', 'response' => $message]);
    }
}