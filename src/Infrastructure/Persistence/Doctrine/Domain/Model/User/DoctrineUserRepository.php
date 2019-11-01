<?php

declare(strict_types=1);

namespace Blog\Infrastructure\Persistence\Doctrine\Domain\Model\User;

use Blog\Domain\Model\User\User;
use Blog\Domain\Model\User\UserId;
use Blog\Domain\Model\User\UserRepository;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineUserRepository implements UserRepository
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
        $this->repository = $this->entityManager->getRepository(User::class);
    }

    /**
     * @return User[]
     */
    public function getAll(): array
    {
        /** @var array $users */
        $users = $this->repository->findAll();
        return $users;
    }

    public function nextIdentity(): UserId
    {
        return new UserId();
    }

    public function findById(UserId $userId): ?User
    {
        /** @var User $user */
        $user = $this->repository->findOneBy(['id.id' => $userId]);
        return $user;
    }
}
