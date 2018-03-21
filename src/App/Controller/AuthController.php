<?php

namespace App\Controller;

use App\Component\AuthComponent;
use App\Helper\JsonResponseTrait;
use Core\App;
use Core\Http\Request\RequestInterface;
use Core\Http\Response\ResponseCode;
use Core\Http\Response\ResponseInterface;

class AuthController
{
    use JsonResponseTrait;

    public function loginAction(): ResponseInterface
    {
        /** @var AuthComponent $authComponent */
        $authComponent = App::container()->get(AuthComponent::class);
        /** @var RequestInterface $request */
        $request = App::container()->get(RequestInterface::class);

        $login = $request->getQueryParam('login');
        $password = $request->getQueryParam('password');
        if ($authComponent->login($login, $password)) {
            return $this->successJsonResponse('login success');
        }

        return $this->errorJsonResponse('login failure', ResponseCode::UNAUTHORIZED);
    }

    public function logoutAction(): ResponseInterface
    {
        /** @var AuthComponent $authComponent */
        $authComponent = App::container()->get(AuthComponent::class);
        $authComponent->logout();

        return $this->successJsonResponse('logout success');
    }
}