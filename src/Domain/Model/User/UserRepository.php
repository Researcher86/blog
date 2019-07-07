<?php


namespace Blog\Domain\Model\User;


interface UserRepository
{
    /**
     * @return User[]
     */
    public function getAll(): array;

    /**
     * @return UserId
     */
    public function nextIdentity(): UserId;

    /**
     * @param UserId $userId
     * @return User
     */
    public function findById(UserId $userId): ?User;
}