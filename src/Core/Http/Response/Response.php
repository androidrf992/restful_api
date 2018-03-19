<?php

namespace Core\Http\Response;

class Response implements ResponseInterface
{
    protected $body;

    protected $statusCode;

    protected $headers = [];

    public function __construct($body, int $statusCode = 200)
    {
        $this->body = $body;
        $this->statusCode = $statusCode;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getHeaders(): iterable
    {
        return $this->headers;
    }

    public function isHaveHeaders(): bool
    {
        return !empty($this->headers);
    }
}