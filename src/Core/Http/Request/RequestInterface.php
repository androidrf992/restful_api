<?php

namespace Core\Http\Request;

use Core\Http\Session\Session;

/**
 * General request interface for requests implementations
 * @package Core\Http\Request
 */
interface RequestInterface
{
    const METHOD_GET = 'GET';

    const METHOD_POST = 'POST';

    const METHOD_PUT = 'PUT';

    const METHOD_DELETE = 'DELETE';

    public function getUri(): string;

    public function getPath(): string;

    public function getMethod(): string;

    public function getSession(): Session;

    public function getQueryParam($param, $default = null);

    public function getAllQueryParams();
}
