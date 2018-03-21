<?php

namespace Core\Http\Request;

use Core\Http\Session\Session;

/**
 * Class Request simple implementation of RequestInterface
 * @package Core\Http\Request
 */
class Request implements RequestInterface
{
    private $getParams;

    private $postParams;

    private $putParams;

    private $serverParams;

    private $session;

    private $cookieParams;

    public function __construct(array $get, array $post, array $server, Session $session, array $cookie)
    {
        $this->getParams = $this->sanitizeParams($get);
        $this->postParams = $this->sanitizeParams($post);
        parse_str(file_get_contents('php://input'), $putParams);
        $this->putParams = $this->sanitizeParams($putParams);
        $this->serverParams = $server;
        $this->session = $session;
        $this->cookieParams = $cookie;
    }

    /**
     * Easy Request Builder from server params
     * @return Request
     */
    public static function initByGlobals(): self
    {
        return new Request($_GET, $_POST, $_SERVER, Session::getInstance(), $_COOKIE);
    }

    /**
     * Get request uri
     *
     * @return string
     */
    public function getUri(): string
    {
        return $this->serverParams['REQUEST_URI'] ?? null;
    }

    /**
     * Get route path
     *
     * @return string
     */
    public function getPath(): string
    {
        $rawUri = $this->getUri();
        $subEndIndex = strpos($rawUri, '?');

        return $subEndIndex
            ? substr($rawUri, 0, strpos($rawUri, '?'))
            : $rawUri;
    }

    /**
     * Get Request method
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->serverParams['REQUEST_METHOD'] ?? null;
    }

    /**
     * Get request param by name
     *
     * @param $param
     * @param null $default
     * @return mixed|null
     */
    public function getQueryParam($param, $default = null)
    {
        if ($this->getMethod() === RequestInterface::METHOD_GET) {
            return $this->getParams[$param] ?? $default;
        } elseif ($this->getMethod() === RequestInterface::METHOD_PUT) {
            return $this->putParams[$param] ?? $default;
        } else {
            return $this->postParams[$param] ?? $default;
        }
    }

    /**
     * Get all request params
     *
     * @return array
     */
    public function getAllQueryParams()
    {
        if ($this->getMethod() === RequestInterface::METHOD_GET) {
            return  $this->getParams;
        } elseif ($this->getMethod() === RequestInterface::METHOD_PUT) {
            return $this->putParams;
        } else {
            return  $this->postParams;
        }
    }

    public function getSession(): Session
    {
        return $this->session;
    }

    /**
     * Sanitaze request params
     *
     * @param $params
     * @return array
     */
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
