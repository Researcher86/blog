<?php

declare(strict_types=1);

namespace Tests\Infrastructure\UI\Web\Middleware;

use Blog\Infrastructure\UI\Web\Middleware\BasicAuthMiddleware;
use Blog\Infrastructure\UI\Web\Template\ViewResponse;
use Blog\Infrastructure\UI\Web\WebApplication;
use PHPUnit\Framework\TestCase;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\ServerRequestFactory;

class BasicAuthMiddlewareTest extends TestCase
{
    /**
     * @var BasicAuthMiddleware
     */
    private $basicAuthMiddleware;
    /**
     * @var array<string, string>
     */
    private $users = [
        'admin' => 'admin',
    ];
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $handler;

    protected function setUp(): void
    {
        $this->basicAuthMiddleware = new BasicAuthMiddleware($this->users);

        $this->handler = $this->createMock(RequestHandlerInterface::class);
        $this->handler->method('handle')->willReturn(
            new ViewResponse(
                'home',
                [],
                200
            )
        );
    }

    public function testProcessAuthSuccess()
    {
        $request = ServerRequestFactory::fromGlobals([
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'admin',
        ]);
        assert($this->handler instanceof RequestHandlerInterface);

        $response = $this->basicAuthMiddleware->process($request, $this->handler);

        self::assertInstanceOf(ViewResponse::class, $response);
        self::assertEquals(200, $response->getStatusCode());
    }

    public function testProcessNotAuth()
    {
        $request = ServerRequestFactory::fromGlobals([]);
        assert($this->handler instanceof RequestHandlerInterface);

        $response = $this->basicAuthMiddleware->process($request, $this->handler);

        self::assertEmpty($response->getBody()->getContents());
        self::assertEquals(401, $response->getStatusCode());
        self::assertEquals('Basic realm=Restricted area', $response->getHeaderLine('WWW-Authenticate'));
    }

    public function testProcessAuthIncorectLogin()
    {
        $request = ServerRequestFactory::fromGlobals([
            'PHP_AUTH_USER' => 'admin2',
            'PHP_AUTH_PW' => 'admin',
        ]);
        assert($this->handler instanceof RequestHandlerInterface);

        $response = $this->basicAuthMiddleware->process($request, $this->handler);

        self::assertEmpty($response->getBody()->getContents());
        self::assertEquals(401, $response->getStatusCode());
    }

    public function testProcessAuthIncorectPassword()
    {
        $request = ServerRequestFactory::fromGlobals([
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'admin2',
        ]);
        assert($this->handler instanceof RequestHandlerInterface);

        $response = $this->basicAuthMiddleware->process($request, $this->handler);

        self::assertEmpty($response->getBody()->getContents());
        self::assertEquals(401, $response->getStatusCode());
    }
}
