<?php

declare(strict_types=1);

namespace Blog\Infrastructure\UI\Web\Handler;

use Blog\Domain\Model\User\UserRepository;
use Blog\Infrastructure\UI\Web\Template\ViewResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class NotFoundHandler implements RequestHandlerInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->userRepository->getAll();
        return new ViewResponse('404', [], 404);
    }
}
