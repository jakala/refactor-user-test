<?php
    declare(strict_types=1);

    namespace TechnicalTest\Domain\Exception;

    use DomainException;

    final class UserNotUpdated extends DomainException
    {
        protected string $pattern = 'User %s not updated';

        public function __construct(string $user)
        {
            $message = sprintf($this->pattern, $user);
            parent::__construct($message);
        }
    }