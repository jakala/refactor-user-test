<?php
    declare(strict_types=1);

    namespace TechnicalTest\Application\Handler;

    use TechnicalTest\Application\Response\UserFoundResponse;
    use TechnicalTest\Infrastructure\MysqlUserRepository;

    final class FindUser
    {
        private MysqlUserRepository $repository;

        public function __construct()
        {
            $this->repository = new MysqlUserRepository();
        }

        public function __invoke(string $uuid): UserFoundResponse
        {
            return new UserFoundResponse(
                $this->repository->find($uuid)
            );
        }
    }