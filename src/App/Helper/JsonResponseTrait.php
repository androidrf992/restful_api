<?php

namespace App\Helper;

use Core\Http\Response\JsonResponse;
use Core\Http\Response\ResponseCode;
use Core\Http\Response\ResponseInterface;

trait JsonResponseTrait
{
    public function successJsonResponse($response, $code = ResponseCode::OK): ResponseInterface
    {
        return new JsonResponse(['status' => 'ok', 'response' => $response], $code);
    }

    public function errorJsonResponse($message, $code = ResponseCode::NOT_FOUND): ResponseInterface
    {
        return new JsonResponse(['status' => 'error', 'message' => $message], $code);
    }
}