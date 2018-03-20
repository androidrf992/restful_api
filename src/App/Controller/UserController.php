<?php

namespace App\Controller;

use App\Helper\JsonResponseTrait;
use App\Service\UserService;
use Core\App;
use Core\Http\Response\JsonResponse;
use Core\Http\Response\ResponseInterface;

class UserController
{
    use JsonResponseTrait;

    public function listAction(): ResponseInterface
    {
        /** @var UserService $service */
        $service = App::container()->get(UserService::class);
        return $this->successJsonResponse($service->getAllUsers());
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