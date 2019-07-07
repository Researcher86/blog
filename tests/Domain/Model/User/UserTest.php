<?php


namespace Tests\Domain\Model\User;


use Blog\Domain\Model\User\User;
use Blog\Domain\Model\User\UserId;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testCreate()
    {
        self::assertNotNull(new User(new UserId(), 'John', 45));

    }

}