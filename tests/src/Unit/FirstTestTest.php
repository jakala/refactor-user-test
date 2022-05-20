<?php

namespace TechnicalTest\Tests\src\Unit;

use PHPUnit\Framework\TestCase;
use TechnicalTest\Tests\src\Domain\UserMother;

class FirstTestTest extends TestCase
{
    public function firstTest(): void
    {
        self::assertTrue(true);
    }

    public function throw_exception_if_user_not_exists(): void
    {
        $user = UserMother::random();
        $this->expectException(\DomainException::class);
        $user->find('a_non_existence_user_id');
    }

    public function save_new_user(): void
    {
        $user = UserMother::random();
        $user->save($user->getId(), $user->getName(), $user->getPhone());
    }

    public function update_an_existence_user(): void
    {
        $user = UserMother::random();
        $user->save($user->getId(), $user->getName(), $user->getPhone());

        $user->save($user->getId(), "new-name", "999999999");
    }
}
