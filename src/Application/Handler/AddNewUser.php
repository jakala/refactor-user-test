<?php
    declare(strict_types=1);

    namespace TechnicalTest\Application\Handler;

    use TechnicalTest\Domain\User;
    use TechnicalTest\Infrastructure\MysqlUserRepository;

    final class AddNewUser
    {
        private MysqlUserRepository  $repository;

        public function __construct()
        {
            $this->repository = new MysqlUserRepository();
        }

        public function __invoke(string $uuid, string $name, string $phone): void
        {
            $user = new User($uuid, $name, $phone);
            $this->repository->save($user);
        }
    }