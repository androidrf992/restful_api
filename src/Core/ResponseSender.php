<?php

namespace Core;

use Core\Http\Response\Response;

class ResponseSender
{
    public function send(Response $response)
    {
        echo $response->getBody();
    }
}