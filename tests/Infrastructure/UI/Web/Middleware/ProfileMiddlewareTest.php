<?php

declare(strict_types=1);

namespace Tests\Infrastructure\UI\Web\Middleware;

use Blog\Infrastructure\UI\Web\Middleware\ProfileMiddleware;
use Blog\Infrastructure\UI\Web\Template\ViewResponse;
use PHPUnit\Framework\TestCase;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\ServerRequestFactory;

class ProfileMiddlewareTest extends TestCase
{
    public function testProcess()
    {
        $handler = $this->createMock(RequestHandlerInterface::class);
        $handler->method('handle')->willReturn(
            new ViewResponse(
                'home',
                [],
                200
            )
        );
        assert($handler instanceof RequestHandlerInterface);
        $start = microtime(true);

        $response = (new ProfileMiddleware())->process(
            ServerRequestFactory::fromGlobals(),
            $handler
        );

        self::assertInstanceOf(ViewResponse::class, $response);
        self::assertEquals(200, $response->getStatusCode());
        $time = (float) $response->getHeaderLine('X-Profiler-Time');
        self::assertTrue($time > 0.0);
        self::assertTrue($time < (microtime(true) - $start));
    }
}
