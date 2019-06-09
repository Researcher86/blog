<?php

namespace Blog\Infrastructure\UI\Web\Handler;

use Blog\Application\Service\ApplicationService;
use Blog\Infrastructure\UI\Web\Template\ViewResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetAllUsersHandler implements RequestHandlerInterface
{
    /**
     * @var ApplicationService
     */
    private $service;


    /**
     * GetAllUsersHandler constructor.
     * @param ApplicationService $service
     */
    public function __construct(ApplicationService $service)
    {
        $this->service = $service;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $users = $this->service->execute($request);

        return new ViewResponse('users', ['users' => $users]);
    }
}