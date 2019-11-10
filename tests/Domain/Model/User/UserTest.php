<?php

declare(strict_types=1);

namespace Tests\Domain\Model\User;

use Blog\Domain\Model\User\User;
use Blog\Domain\Model\User\UserId;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testCreate(): void
    {
        $user = new User($userId = new UserId(), $name = 'John', $age = 45);
        self::assertTrue($user->getId()->equals($userId));
        self::assertEquals($user->getName(), $name);
        self::assertEquals($user->getAge(), $age);
    }

    public function testEquals(): void
    {
        $userFirst = new User($userId = new UserId(), $name = 'John', $age = 45);
        $userSecond = clone $userFirst;
        $userThird = new User($userId = new UserId(), $name = 'John2', $age = 46);

        self::assertTrue($userFirst->equals($userSecond));
        self::assertFalse($userFirst->equals($userThird));
        self::assertFalse($userSecond->equals($userThird));
    }
}
