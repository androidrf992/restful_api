<?php

namespace Core\Http\Request;

class Request implements RequestInterface
{
    private $getParams;

    private $postParams;

    private $sanitizeParams = [];

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

    public function getQueryParam($param, $default = null)
    {
        if (isset($this->sanitizeParams[$param])) {
            return $this->sanitizeParams[$param];
        }
        if ($this->getMethod() === RequestInterface::METHOD_GET) {
            $this->sanitizeParams[$param] = strip_tags($_GET[$param]) ?? $default;
        } else {
            $this->sanitizeParams[$param] = strip_tags($_POST[$param]) ?? $default;
        }

        return $this->sanitizeParams[$param];
    }
}