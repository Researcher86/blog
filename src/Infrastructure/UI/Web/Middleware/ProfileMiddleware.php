<?php

declare(strict_types=1);

namespace Blog\Infrastructure\UI\Web\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class ProfileMiddleware implements MiddlewareInterface
{
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $start = microtime(true);

        $response = $handler->handle($request);

        return $response->withHeader(
            'X-Profiler-Time',
            (string) (microtime(true) - $start)
        );
    }
}
