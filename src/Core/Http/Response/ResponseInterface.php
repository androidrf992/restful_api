<?php

namespace Core\Http\Response;

/**
 * General response interface for response implementations
 * @package Core\Http\Response
 */
interface ResponseInterface
{
    public function getStatusCode(): int;

    public function getBody();

    public function getHeaders(): array;

    public function isHaveHeaders(): bool;

    public function addHeader(string $key, string $val);
}
