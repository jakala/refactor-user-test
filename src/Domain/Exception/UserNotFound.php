<?php
    declare(strict_types=1);

    namespace TechnicalTest\Domain\Exception;

    use DomainException;

    final class UserNotFound extends DomainException
    {
        protected string $pattern = 'User %s not found';

        public function __construct(string $user)
        {
            $message = sprintf($this->pattern, $user);
            parent::__construct($message);
        }
    }