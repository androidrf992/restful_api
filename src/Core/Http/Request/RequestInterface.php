<?php

namespace Core\Http\Request;

interface RequestInterface
{
    const METHOD_GET = 'GET';

    const METHOD_POST = 'POST';

    const METHOD_PUT = 'PUT';

    const METHOD_DELETE = 'DELETE';

    public function getUri(): string;

    public function getMethod(): string;

    public function getQueryParam($param, $default = null);
}