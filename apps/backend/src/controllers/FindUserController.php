<?php
    declare(strict_types=1);

    namespace TechnicalTest\backend\controllers;

    use DomainException;
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use TechnicalTest\Application\Response\UserFoundResponse;
    use TechnicalTest\Domain\User;
    use TechnicalTest\Infrastructure\MysqlUserRepository;

    final class FindUserController
    {
        private MysqlUserRepository $repository;

        public function __construct()
        {
            $this->repository = new MysqlUserRepository();
        }

        public function id(Request $request, Response $response, array $args): Response
        {
            try {
                $user = $this->repository->find($args['id']);
                return $this->createResponse($user, $response);
            } catch (DomainException $e) {
                return $response->withStatus(404);
            }
        }

        private function createResponse(User $user, Response $response): Response
        {
            $dataResponse = (new UserFoundResponse($user))->jsonSerialize();
            $response->getBody()->write($dataResponse);
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        }
    }