<?php

namespace Tests\Application\Service\User;

use Blog\Application\Service\User\UserService;
use Blog\Domain\Model\User\User;
use Blog\Domain\Model\User\UserId;
use Blog\Domain\Model\User\UserRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class UserServiceTest
 * @package Blog\Application\Service\User
 */
class UserServiceTest extends TestCase
{
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var MockObject
     */
    private $userRepository;

    /**
     * @var array
     */
    private $users;

    /**
     * @throws \ReflectionException
     */
    protected function setUp(): void
    {
        $this->users = [
            new User(new UserId('7afcd67d-790d-48c4-9922-0a085f5d27ac'), 'User 1', 15),
            new User(new UserId('7afcd67d-790d-48c4-9923-0a085f5d27ac'), 'User 2', 18),
        ];

        $this->userRepository = $this->createMock(UserRepository::class);
        assert($this->userRepository instanceof UserRepository);
        $this->userService = new UserService($this->userRepository);
    }


    public function testGetAllUsers()
    {
        $this->userRepository->method('getAll')->willReturn($this->users);
        $users = $this->userService->getAllUsers();
        self::assertEquals($this->users, $users);
    }
}
