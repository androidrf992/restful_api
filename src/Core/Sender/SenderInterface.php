<?php

namespace Core\Sender;

use Core\Http\Response\ResponseInterface;

/**
 * Interface for response send to client
 * @package Core\Sender
 */
interface SenderInterface
{
    public function send(ResponseInterface $response);
}
