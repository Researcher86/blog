<?php

declare(strict_types=1);

namespace Blog\Infrastructure\Persistence\Doctrine\Domain\Model\Post;

use Blog\Domain\Model\Post\Post;
use Blog\Domain\Model\Post\PostId;
use Blog\Domain\Model\Post\PostRepository;
use Blog\Domain\Model\User\UserId;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrinePostRepository implements PostRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var ObjectRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Post::class);
    }

    /**
     * @return array<Post>
     */
    public function getAll(): array
    {
        /** @var array<Post> $posts */
        $posts = $this->repository->findAll();
        return $posts;
    }

    public function nextIdentity(): PostId
    {
        return new PostId();
    }

    /**
     * @param UserId $userId
     *
     * @return array<Post>
     */
    public function findByUser(UserId $userId): array
    {
        /** @var array<Post> $posts */
        $posts = $this->repository->findBy(['userId.id' => $userId]);
        return $posts;
    }

    public function findById(PostId $postId): ?Post
    {
        /** @var Post $post */
        $post = $this->repository->find($postId);
        return $post;
    }
}
