<?php

namespace Core\Http\Request;

class Request implements RequestInterface
{
    private $getParams;

    private $postParams;

    private $serverParams;

    private $sessionParams;

    private $cookieParams;

    public function __construct(array $get, array $post, array $server, array $session, array $cookie)
    {
        $this->getParams = $get;
        $this->postParams = $post;
        $this->serverParams = $server;
        $this->sessionParams = $session;
        $this->cookieParams = $cookie;
    }

    public static function initByGlobals(): self
    {
        return new Request($_GET, $_POST, $_SERVER, $_SESSION, $_COOKIE);
    }

    public function getUri(): string
    {
        return $this->serverParams['REQUEST_URI'] ?? null;
    }

    public function getMethod(): string
    {
        return $this->serverParams['REQUEST_METHOD'] ?? null;
    }
}