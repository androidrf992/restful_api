<?php

namespace Core\Http\Request;

use Core\Http\Session\Session;

class Request implements RequestInterface
{
    private $getParams;

    private $postParams;

    private $serverParams;

    private $session;

    private $cookieParams;

    public function __construct(array $get, array $post, array $server, Session $session, array $cookie)
    {
        $this->getParams = $this->sanitizeParams($get);
        $this->postParams = $this->sanitizeParams($post);
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
        if ($this->getMethod() === RequestInterface::METHOD_GET) {
            return $this->getParams[$param] ?? $default;
        } else {
            return $this->postParams[$param] ?? $default;
        }
    }

    public function getAllQueryParams()
    {
        if ($this->getMethod() === RequestInterface::METHOD_GET) {
            return  $this->getParams;
        } else {
            return  $this->postParams;
        }
    }

    private function sanitizeParams($params)
    {
        $sanitizedParams = [];
        if (!empty($params)) {
            foreach ($params as $key => $param) {
                $sanitizedParams[$key] = trim(strip_tags($param));
            }
        }
        return $sanitizedParams;
    }
}
