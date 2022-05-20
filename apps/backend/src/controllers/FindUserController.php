<?php
    declare(strict_types=1);

    namespace TechnicalTest\backend\controllers;

    use DomainException;
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use TechnicalTest\User\User;

    final class FindUserController
    {
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