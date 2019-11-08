<?php

declare(strict_types=1);

namespace Tests\Domain\Model\User;

use Blog\Domain\Model\User\User;
use Blog\Domain\Model\User\UserId;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testCreate()
    {
        $user = new User($userId = new UserId(), $name = 'John', $age = 45);
        self::assertTrue($user->getId()->equals($userId));
        self::assertEquals($user->getName(), $name);
        self::assertEquals($user->getAge(), $age);
    }
}
