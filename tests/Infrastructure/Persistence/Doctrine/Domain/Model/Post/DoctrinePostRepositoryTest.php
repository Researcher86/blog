<?php

namespace Tests\Infrastructure\Persistence\Doctrine\Domain\Model\Post;

use Blog\Domain\Model\Post\PostRepository;
use Blog\Domain\Model\User\UserId;
use Blog\Infrastructure\Persistence\Doctrine\Domain\Model\Post\DoctrinePostRepository;
use PHPUnit\Framework\TestCase;

class DoctrinePostRepositoryTest extends TestCase
{
    /**
     * @var PostRepository
     */
    private $repository;

    protected function setUp(): void
    {
        $container = include 'config/container.php';
        $this->repository = $container->get(DoctrinePostRepository::class);
    }


    public function testFindByUser()
    {
        self::assertNotEmpty($this->repository->findByUser(new UserId('11111111-1111-1111-1111-111111111111')));
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
