<?php


namespace Blog\Domain\Model\User;


interface UserRepository
{
    public function getAll();

    /**
     * @return UserId
     */
    public function nextIdentity(): UserId;
}