<?php

namespace App\Component;

use Core\Http\Request\RequestInterface;

class AuthComponent
{
    private $request;

    private $login = 'admin';

    private $password = 'qwerty';

    public function __construct(RequestInterface $request, $login, $password)
    {
        $this->request = $request;
        $this->login = $login;
        $this->password = $password;
    }

    public function login($login, $password): bool
    {
        if ($login === $this->login && $password === $this->password) {
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