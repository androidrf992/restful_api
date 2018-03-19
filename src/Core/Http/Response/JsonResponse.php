<?php

namespace Core\Http\Response;

use Core\Http\Response\Exceptions\JsonResponseNotValidBodyException;

class JsonResponse extends Response
{
    public function __construct($body, int $statusCode = 200)
    {
        $normalizeBody = json_encode($body);
        if (!$normalizeBody) {
            throw new JsonResponseNotValidBodyException('Not valid body given for json response');
        }
        $this->addHeader('Content-Type', 'application/json');

        parent::__construct($normalizeBody, $statusCode);
    }
}