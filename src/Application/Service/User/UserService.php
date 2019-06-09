<?php

namespace Blog\Application\Service\User;

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
     * @param $request
     * @return mixed
     */
    public function getAll($request)
    {
//        throw new \DomainException();
        return $this->userRepository->getAll();
    }
}