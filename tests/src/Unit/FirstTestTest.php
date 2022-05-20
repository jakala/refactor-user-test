<?php

namespace TechnicalTest\Tests\src\Unit;

use PHPUnit\Framework\TestCase;
use TechnicalTest\Tests\src\Domain\UserMother;
use TechnicalTest\User\User;

class FirstTestTest extends TestCase
{
    /** @test */
    public function firstTest(): void
    {
        self::assertTrue(true);
    }

    /** @test */
    public function throw_exception_if_user_not_exists(): void
    {
        $this->expectException(\DomainException::class);
        User::find('a_non_existence_user_id');
    }

    /** @test */
    public function save_new_user(): void
    {
        $user = UserMother::random();
        User::save($user->getId(), $user->getName(), $user->getPhone());
    }

    /** @test */
    public function update_an_existence_user(): void
    {
        $user = UserMother::random();
        User::save($user->getId(), $user->getName(), $user->getPhone());

        User::save($user->getId(), "new-name", "999999999");

    }
}
