<?php

namespace Core\Http\Response;

/**
 * Response codes enumerate
 * @package Core\Http\Response
 */
class ResponseCode
{
    const OK = 200;

    const UNAUTHORIZED = 401;

    const NOT_FOUND = 404;

    const METHOD_NOT_ALLOWED = 405;

    const INTERNAL_SERVER_ERROR = 500;
}
