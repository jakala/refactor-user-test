<?php
    declare(strict_types=1);

    namespace TechnicalTest\Tests\src\Domain;

    use TechnicalTest\User\User;

    final class UserMother
    {
        private const NAMES = ['Lucia','Silvia','Elisa','Marcos','Sergio','Angel','Ivan'];

        public static function random(): User
        {
            return new User(self::randomId(), self::randomName(), self::randomPhone());
        }

        public static function defined(string $uuid, string $name, string $phone): User
        {
            return new User($uuid, $name, $phone);
        }

        private static function randomId(string $data = null): string
        {
            $data = $data ?? random_bytes(16);
            assert(strlen($data) == 16);
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

            return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
        }

        private static function randomPhone(): string
        {
            return (string) random_int(600000000, 699999999);
        }

        private static function randomName(): string
        {
            return self::NAMES[random_int(0, count(self::NAMES) - 1)];
        }
    }
