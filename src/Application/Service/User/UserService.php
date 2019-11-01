<?php

declare(strict_types=1);

namespace Blog\Application\Service\User;

use Blog\Domain\Model\User\User;
use Blog\Domain\Model\User\UserRepository;
use Blog\Infrastructure\Application\Transactional;

final class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Transactional()
     *
     * @return User[]
     */
    public function getAllUsers(): array
    {
//        throw new \DomainException();
        return $this->userRepository->getAll();
    }
}
