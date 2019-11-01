<?php

declare(strict_types=1);

namespace Blog\Domain\Model\User;

interface UserRepository
{
    /**
     * @return User[]
     */
    public function getAll(): array;

    public function nextIdentity(): UserId;

    public function findById(UserId $userId): ?User;
}
