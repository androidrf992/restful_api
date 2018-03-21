<?php

namespace App\Controller;

use App\Entity\User;
use App\Helper\JsonResponseTrait;
use App\Service\UserService;
use Core\App;
use Core\Container\ServiceNotFoundException;
use Core\Http\Response\JsonResponse;
use Core\Http\Response\ResponseInterface;

class UserController
{
    use JsonResponseTrait;

    /**
     * @throws ServiceNotFoundException
     *
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
    {
        $jsonRecords = [];
        /** @var UserService $service */
        $service = App::container()->get(UserService::class);
        $userCollection = $service->getAllUsers();
        if (!empty($userCollection)) {
            /** @var  $item */
            foreach ($userCollection as $item) {
                $jsonRecords[] = User::toArray($item);
            }
        }

        return $this->successJsonResponse($jsonRecords);
    }

    public function getAction($userId): ResponseInterface
    {
        return new JsonResponse(['get', $userId]);
    }

    public function createAction(): ResponseInterface
    {
        try {
            /** @var UserService $service */
            $service = App::container()->get(UserService::class);
            $user = new User('dasda', User::GENDER_MALE, 10, 'dasda');
            $service->createUser($user);
            return $this->successJsonResponse('created');
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
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