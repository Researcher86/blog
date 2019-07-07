<?php

namespace Blog\Infrastructure\Persistence\Doctrine\Domain\Model\User;

use Blog\Domain\Model\User\User;
use Blog\Domain\Model\User\UserId;
use Blog\Domain\Model\User\UserRepository;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineUserRepository implements UserRepository
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
        $this->repository = $this->em->getRepository(User::class);
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @return UserId
     */
    public function nextIdentity(): UserId
    {
        return new UserId();
    }

    /**
     * @param UserId $userId
     * @return null|User
     */
    public function findById(UserId $userId): ?User
    {
        /** @var User $user */
        $user = $this->repository->findOneBy(['id.id' => $userId]);
        return $user;
    }
}