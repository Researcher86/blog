<?php

namespace Tests\Domain\Model\User;

use Blog\Domain\Model\User\UserId;
use Blog\Domain\Model\User\UserRepository;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    /**
     * @var UserRepository
     */
    private $repository;

    protected function setUp(): void
    {
        $container = include 'config/container.php';
        $this->repository = $container->get(UserRepository::class);
    }

    public function testFindById()
    {
        $userId = new UserId('11111111-1111-1111-1111-111111111111');

        $user = $this->repository->findById($userId);

        self::assertNotNull($user);
        self::assertTrue($user ? $user->getId()->equals($userId) : false);
    }

    public function testFindByIdReturnNull()
    {
        $userId = new UserId();

        $user = $this->repository->findById($userId);

        self::assertNull($user);
    }

    public function testGetAll()
    {
        self::assertNotEmpty($this->repository->getAll());
    }

    public function testNextIdentity()
    {
        self::assertNotNull($this->repository->nextIdentity());
    }
}
