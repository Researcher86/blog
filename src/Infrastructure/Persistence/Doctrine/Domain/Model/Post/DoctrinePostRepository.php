<?php


namespace Blog\Infrastructure\Persistence\Doctrine\Domain\Model\Post;

use Blog\Domain\Model\Post\Post;
use Blog\Domain\Model\Post\PostId;
use Blog\Domain\Model\Post\PostRepository;
use Blog\Domain\Model\User\UserId;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrinePostRepository implements PostRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var ObjectRepository
     */
    private $repository;


    /**
     * DoctrineUserRepository constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(Post::class);
    }


    public function getAll(): array
    {
        /** @var Post[] $posts */
        $posts = $this->repository->findAll();
        return $posts;
    }

    public function nextIdentity(): PostId
    {
        return new PostId();
    }

    public function findByUser(UserId $userId): array
    {
        /** @var Post[] $posts */
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
