<?php

namespace App\Controller;

use Core\Http\Response\JsonResponse;
use Core\Http\Response\ResponseInterface;

class UserController
{
    public function listAction(): ResponseInterface
    {
        return new JsonResponse(['list']);
    }

    public function getAction($userId): ResponseInterface
    {
        return new JsonResponse(['get', $userId]);
    }

    public function createAction(): ResponseInterface
    {
        return new JsonResponse(['create']);
    }

    public function updateAction($userId): ResponseInterface
    {
        return new JsonResponse(['updateAction']);
    }

    public function deleteAction($userId): ResponseInterface
    {
        return new JsonResponse(['deleteAction']);
    }
}