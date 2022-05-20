<?php
    declare(strict_types=1);

    namespace TechnicalTest\Domain\Exception;

    final class UserNotSave extends \DomainException
    {
        protected string $pattern = 'User %s not saved';

        public function __construct(string $user)
        {
            $message = sprintf($this->pattern, $user);
            parent::__construct($message);
        }
    }