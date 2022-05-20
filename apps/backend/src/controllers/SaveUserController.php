<?php

namespace TechnicalTest\backend\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use TechnicalTest\Application\Handler\AddNewUser;
use TechnicalTest\Infrastructure\MysqlUserRepository;

class SaveUserController
{
    private AddNewUser $handler;

    public function __construct()
    {
        $this->handler = new AddNewUser();
    }

    public function add(Request $request, Response $response, array $args): Response
    {
        $body = json_decode($request->getBody(), true, 512, JSON_THROW_ON_ERROR);

        $this->handler->__invoke($args['id'], $body['name'], $body['phone']);

        return $response->withStatus(201);
    }
}

