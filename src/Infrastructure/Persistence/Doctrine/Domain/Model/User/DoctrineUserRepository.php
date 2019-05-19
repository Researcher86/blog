<?php


namespace Blog\Infrastructure\Persistence\Doctrine\Domain\Model\User;


use Blog\Domain\Model\User\User;
use Blog\Domain\Model\User\UserId;
use Blog\Domain\Model\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineUserRepository implements UserRepository
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
        return $this->em->getRepository(User::class)->findAll();
    }

    /**
     * @return UserId
     */
    public function nextIdentity(): UserId
    {
        return new UserId();
    }
}