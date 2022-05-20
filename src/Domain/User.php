<?php
    declare(strict_types=1);

    namespace TechnicalTest\Domain;

    final class User
    {
        private string $uuid;
        private string $name;
        private string $phone;

        public function __construct(string $uuid, string $name, string $phone)
        {
            $this->uuid = $uuid;
            $this->name = $name;
            $this->phone = $phone;
        }

        public function uuid(): string
        {
            return $this->uuid;
        }

        public function name(): string
        {
            return $this->name;
        }

        public function phone(): string
        {
            return $this->phone;
        }
    }