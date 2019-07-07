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


    public function getAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @return PostId
     */
    public function nextIdentity(): PostId
    {
        return new PostId();
    }

    /**
     * @param UserId $userId
     * @return Post[]
     */
    public function findByUser(UserId $userId): array
    {
        return $this->repository->findBy(['userId.id' => $userId]);
    }
}