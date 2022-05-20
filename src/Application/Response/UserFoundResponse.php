<?php
    declare(strict_types=1);

    namespace TechnicalTest\Application\Response;

    use TechnicalTest\Domain\User;

    final class UserFoundResponse implements \JsonSerializable
    {
        private User $user;
        public function __construct(User $user)
        {
            $this->user = $user;
        }

        public function jsonSerialize(): string
        {
            return json_encode([
                'id' => $this->user->uuid(),
                'name' => $this->user->name(),
                'phone' => $this->user->phone()
            ],JSON_THROW_ON_ERROR, 512);
        }
    }