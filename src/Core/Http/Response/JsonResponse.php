<?php

namespace Core\Http\Response;

/**
 * Json Response
 * @package Core\Http\Response
 */
class JsonResponse extends Response
{
    public function __construct($body, int $statusCode = ResponseCode::OK)
    {
        $normalizeBody = json_encode($body);

        $this->addHeader('Content-Type', 'application/json');

        parent::__construct($normalizeBody, $statusCode);
    }
}
