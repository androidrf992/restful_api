<?php

namespace Core\Sender;

use Core\Http\Response\ResponseInterface;

class SimpleHtmlSender implements SenderInterface
{
    public function send(ResponseInterface $response)
    {
        http_response_code($response->getStatusCode());
        if ($response->isHaveHeaders()) {
            foreach ($response->getHeaders() as $name => $value) {
                header($name . ':' . $value);
            }
        }

        echo $response->getBody();
    }
}