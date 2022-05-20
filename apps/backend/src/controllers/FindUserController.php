<?php
    declare(strict_types=1);

    namespace TechnicalTest\backend\controllers;

    use DomainException;
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use TechnicalTest\Application\Handler\FindUser;

    final class FindUserController
    {
        private FindUser $handler;

        public function __construct()
        {
            $this->handler = new FindUser();
        }

        public function id(Request $request, Response $response, array $args): Response
        {
            try {
                $userResponse = $this->handler->__invoke($args['id'])->jsonSerialize();
                $response->getBody()->write($userResponse);
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(200);
            } catch (DomainException $e) {
                return $response->withStatus(404);
            }
        }
    }