<?php

namespace Core\Http\Request;

use Core\Http\Session\Session;

class Request implements RequestInterface
{
    private $getParams;

    private $postParams;

    private $sanitizeParams = [];

    private $serverParams;

    private $session;

    private $cookieParams;

    public function __construct(array $get, array $post, array $server, Session $session, array $cookie)
    {
        $this->getParams = $get;
        $this->postParams = $post;
        $this->serverParams = $server;
        $this->session = $session;
        $this->cookieParams = $cookie;
    }

    public static function initByGlobals(): self
    {
        return new Request($_GET, $_POST, $_SERVER, Session::getInstance(), $_COOKIE);
    }

    public function getUri(): string
    {
        return $this->serverParams['REQUEST_URI'] ?? null;
    }

    public function getPath(): string
    {
        $rawUri = $this->getUri();
        $subEndIndex = strpos($rawUri, '?');

        return $subEndIndex
            ? substr($rawUri, 0, strpos($rawUri, '?'))
            : $rawUri;
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
