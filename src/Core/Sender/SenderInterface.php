<?php

namespace Core\Sender;

use Core\Http\Response\ResponseInterface;

interface SenderInterface
{
    public function send(ResponseInterface $response);
}
