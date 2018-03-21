<?php

namespace App\Middleware;

use App\Component\AuthComponent;
use App\Helper\JsonResponseTrait;
use Core\App;
use Core\Http\Response\ResponseCode;
use Core\Middleware\AbstractMiddleware;

class AuthMiddleware extends AbstractMiddleware
{
    use JsonResponseTrait;

    public function run(\Closure $next)
    {
        /** @var AuthComponent $component */
        $component = App::container()->get(AuthComponent::class);
        if (!$component->isAuthenticated()) {
            return $this->errorJsonResponse('Need login to process request', ResponseCode::UNAUTHORIZED);
        }

        return $next();
    }
}