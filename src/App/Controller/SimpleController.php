<?php

namespace App\Controller;

use Core\Http\Response\JsonResponse;
use Core\Http\Response\Response;
use Core\Http\Response\ResponseInterface;

class SimpleController
{
    public function indexAction(): ResponseInterface
    {
        return new JsonResponse(['status' => 'ok', 'response' =>'success']);
    }

    public function paramAction($user_id, $partner_id):ResponseInterface
    {
        return new Response("{$user_id} - {$partner_id}");
    }
}