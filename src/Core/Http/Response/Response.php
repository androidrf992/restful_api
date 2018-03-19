<?php

namespace Core\Http\Response;

class Response
{
    private $body;

    public function __construct($body)
    {
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }
}