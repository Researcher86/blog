<?php

namespace Blog\Infrastructure\UI\Web\Handler\User;

use Blog\Application\Service\User\UserService;
use Blog\Infrastructure\UI\Web\Template\ViewResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetAllUsersHandler implements RequestHandlerInterface
{
    /**
     * @var UserService
     */
    private $service;


    /**
     * GetAllUsersHandler constructor.
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $users = $this->service->getAllUsers();

        return new ViewResponse('users/list', ['users' => $users]);
    }
}
