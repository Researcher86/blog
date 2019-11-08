<?php

declare(strict_types=1);

namespace Tests\Infrastructure\UI\Web\Middleware;

use Blog\Infrastructure\UI\Web\Middleware\BasicAuthMiddleware;
use Blog\Infrastructure\UI\Web\WebApplication;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequestFactory;

class BasicAuthMiddlewareTest extends TestCase
{
    /**
     * @var WebApplication
     */
    private $app;

    protected function setUp(): void
    {
        $container = include 'config/container.php';
        $this->app = $container->get(WebApplication::class);
    }

    public function testProcessNotAuth()
    {
        /** @var HtmlResponse $response */
        $response = $this->app->run(ServerRequestFactory::fromGlobals([
            'REQUEST_URI' => '/admin',
            'REQUEST_METHOD' => 'GET',
        ]));

        self::assertEmpty($response->getBody()->getContents());
        self::assertEquals(401, $response->getStatusCode());
        self::assertEquals('Basic realm=Restricted area', $response->getHeaderLine('WWW-Authenticate'));
    }

    public function testProcessAuthSuccess()
    {
        /** @var HtmlResponse $response */
        $response = $this->app->run(ServerRequestFactory::fromGlobals([
            'REQUEST_URI' => '/admin',
            'REQUEST_METHOD' => 'GET',
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'admin',
        ]));

        self::assertNotEmpty($response->getBody()->getContents());
        self::assertEquals(404, $response->getStatusCode());
    }

    public function testProcessAuthIncorectLogin()
    {
        /** @var HtmlResponse $response */
        $response = $this->app->run(ServerRequestFactory::fromGlobals([
            'REQUEST_URI' => '/admin',
            'REQUEST_METHOD' => 'GET',
            'PHP_AUTH_USER' => 'admin2',
            'PHP_AUTH_PW' => 'admin',
        ]));

        self::assertEmpty($response->getBody()->getContents());
        self::assertEquals(401, $response->getStatusCode());
    }

    public function testProcessAuthIncorectPassword()
    {
        /** @var HtmlResponse $response */
        $response = $this->app->run(ServerRequestFactory::fromGlobals([
            'REQUEST_URI' => '/admin',
            'REQUEST_METHOD' => 'GET',
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'admin2',
        ]));

        self::assertEmpty($response->getBody()->getContents());
        self::assertEquals(401, $response->getStatusCode());
    }
}
