<?php

namespace Blog\Application\Service\User;

use Blog\Domain\Model\User\User;
use Blog\Domain\Model\User\UserRepository;
use Blog\Infrastructure\Application\Transactional;

class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;


    /**
     * GetAllUserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Transactional
     * @return User[]
     */
    public function getAllUsers(): array
    {
//        throw new \DomainException();
        return $this->userRepository->getAll();
    }
}
