<?php


namespace Blog\Application\Service\User;


use Blog\Application\Service\ApplicationService;
use Blog\Domain\Model\User\UserRepository;

class GetAllUsersService implements ApplicationService
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

    public function execute($request)
    {
        return $this->userRepository->getAll();
    }
}