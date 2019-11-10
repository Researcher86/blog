<?php

namespace Tests\Domain\Model\Post;

use Blog\Domain\Model\Post\PostRepository;
use Blog\Domain\Model\User\UserId;
use PHPUnit\Framework\TestCase;

class PostRepositoryTest extends TestCase
{
    /**
     * @var PostRepository
     */
    private $repository;

    protected function setUp(): void
    {
        $container = include 'config/container.php';
        $this->repository = $container->get(PostRepository::class);
    }

    public function testFindByUser()
    {
        $userId = new UserId('11111111-1111-1111-1111-111111111111');
        $posts = $this->repository->findByUser($userId);
        self::assertNotEmpty($posts);

        foreach ($posts as $post) {
            self::assertTrue($post->getUserId()->equals($userId));
        }
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
