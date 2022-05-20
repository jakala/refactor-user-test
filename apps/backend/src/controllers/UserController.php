<?php

namespace TechnicalTest\backend\controllers;

use DomainException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use TechnicalTest\User\User;

class UserController
{
    public function add(Request $request, Response $response, array $args): Response
    {
        $body = json_decode($request->getBody(), true, 512, JSON_THROW_ON_ERROR);

        User::save($args['id'], $body['name'], $body['phone']);

        return $response->withStatus(201);
    }

    public function id(Request $request, Response $response, array $args): Response
    {
        try {
            $user = User::find($args['id']);
            $dataResponse = json_encode(
                ['id' => $user->getId(), 'name' => $user->getName(), 'phone' => $user->getPhone()],
                JSON_THROW_ON_ERROR,
                512
            );
            $response->getBody()->write($dataResponse);
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        } catch (DomainException $e) {
            return $response->withStatus(404);
        }
    }
}
