<?php


namespace Blog\Infrastructure\Persistence\Doctrine\Domain\Model\Post;


use Blog\Domain\Model\Post\Post;
use Blog\Domain\Model\Post\PostId;
use Blog\Domain\Model\Post\PostRepository;
use Blog\Domain\Model\User\UserId;
use Doctrine\ORM\EntityManagerInterface;

class DoctrinePostRepository implements PostRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $em;


    /**
     * DoctrineUserRepository constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function getAll()
    {
        return $this->em->getRepository(Post::class)->findAll();
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
        return $this->em->getRepository(Post::class)->findBy(['userId.id' => $userId]);
    }
}