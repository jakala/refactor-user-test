<?php
    declare(strict_types=1);

    namespace TechnicalTest\backend\controllers;

    use DomainException;
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use TechnicalTest\Infrastructure\MysqlUserRepository;
    use TechnicalTest\User\User;

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
                $dataResponse = json_encode(
                    ['id' => $user->uuid(), 'name' => $user->name(), 'phone' => $user->phone()],
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