<?php

declare(strict_types=1);

namespace Blog\Infrastructure\UI\Web\Handler;

use Blog\Infrastructure\UI\Web\Template\ViewResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class NotFoundHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new ViewResponse('404', [], 404);
    }
}
