<?php

namespace App\Component;

use Core\Http\Request\RequestInterface;

class AuthComponent
{
    private $request;

    private $userName = 'admin';

    private $userPassword = 'qwerty';

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function login($login, $password): bool
    {
        if ($login === $this->userName && $password === $this->userPassword) {
            $this->request->getSession()->set('auth', true);
            return true;
        }

        return false;
    }

    public function logout()
    {
        $this->request->getSession()->remove('auth');
    }

    public function isAuthenticated():bool
    {
        $session = $this->request->getSession();

        return $session->has('auth') && $session->get('auth') === true;
    }
}