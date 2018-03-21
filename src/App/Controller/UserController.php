<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserForm;
use App\Helper\JsonResponseTrait;
use App\Service\UserService;
use Core\App;
use Core\Http\Request\RequestInterface;
use Core\Http\Response\JsonResponse;
use Core\Http\Response\ResponseInterface;

class UserController
{
    use JsonResponseTrait;

    public function listAction(): ResponseInterface
    {
        try {
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
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function getAction($userId): ResponseInterface
    {
        try {
            /** @var UserService $service */
            $service = App::container()->get(UserService::class);
            $userEntity = $service->getUser($userId);

            return $this->successJsonResponse(User::toArray($userEntity));
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function createAction(): ResponseInterface
    {
        try {
            /** @var UserService $service */
            $service = App::container()->get(UserService::class);
            /** @var RequestInterface $request */
            $request = App::container()->get(RequestInterface::class);
            $form = new UserForm();
            if (!$form->validate($request)) {
                return $this->errorJsonResponse($form->getError());
            }

            $user = new User(
                $request->getQueryParam('name'),
                $request->getQueryParam('gender'),
                $request->getQueryParam('age'),
                $request->getQueryParam('address')
            );

            $service->createUser($user);

            return $this->successJsonResponse('created');
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function updateAction($userId): ResponseInterface
    {
        try {
            /** @var UserService $service */
            $service = App::container()->get(UserService::class);
            /** @var RequestInterface $request */
            $request = App::container()->get(RequestInterface::class);
            $form = new UserForm();
            if (!$form->validate($request)) {
                return $this->errorJsonResponse($form->getError());
            }
            $user = $service->getUser($userId);
            $user->setAddress($request->getQueryParam('address'));
            $user->setName($request->getQueryParam('name'));
            $user->setGender($request->getQueryParam('gender'));
            $user->setAge($request->getQueryParam('age'));
            $service->saveUser($user);

            return $this->successJsonResponse('created');
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function deleteAction($userId): ResponseInterface
    {
        try {
            /** @var UserService $service */
            $service = App::container()->get(UserService::class);
            $user = $service->getUser($userId);
            $service->removeUser($user);

            return $this->successJsonResponse('deleted');
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
}