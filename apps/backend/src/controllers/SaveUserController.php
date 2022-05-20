<?php

namespace TechnicalTest\backend\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use TechnicalTest\User\User;

class SaveUserController
{
    public function add(Request $request, Response $response, array $args): Response
    {
        $body = json_decode($request->getBody(), true, 512, JSON_THROW_ON_ERROR);

        User::save($args['id'], $body['name'], $body['phone']);

        return $response->withStatus(201);
    }

}
