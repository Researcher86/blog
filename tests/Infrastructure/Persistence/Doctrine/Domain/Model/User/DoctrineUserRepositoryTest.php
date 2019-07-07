<?php

namespace Tests\Infrastructure\Persistence\Doctrine\Domain\Model\Post;

use Blog\Domain\Model\User\UserId;
use Blog\Domain\Model\User\UserRepository;
use Blog\Infrastructure\Persistence\Doctrine\Domain\Model\User\DoctrineUserRepository;
use PHPUnit\Framework\TestCase;

class DoctrineUserRepositoryTest extends TestCase
{
    /**
     * @var UserRepository
     */
    private $repository;

    protected function setUp(): void
    {
        $container = include 'config/container.php';
        $this->repository = $container->get(DoctrineUserRepository::class);
    }


    public function testFindById()
    {
        self::assertNotEmpty($this->repository->findById(new UserId('11111111-1111-1111-1111-111111111111')));
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
