<?php

namespace Core\Http\Response;

/**
 * Simple html response
 *
 * @package Core\Http\Response
 */
class Response implements ResponseInterface
{
    protected $body;

    protected $statusCode;

    protected $headers = [];

    public function __construct($body, int $statusCode = ResponseCode::NOT_FOUND)
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

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function isHaveHeaders(): bool
    {
        return !empty($this->headers);
    }

    public function addHeader(string $name, string $value)
    {
        $this->headers[$name] = $value;
    }
}
