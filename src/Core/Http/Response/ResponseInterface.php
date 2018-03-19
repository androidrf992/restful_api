<?php

namespace Core\Http\Response;

interface ResponseInterface
{
    public function getStatusCode(): int;

    public function getBody();

    public function getHeaders(): iterable;

    public function isHaveHeaders(): bool;
}