<?php

declare(strict_types=1);

namespace Tests\Infrastructure\UI\Web\Middleware;

use Blog\Infrastructure\UI\Web\Middleware\ProfileMiddleware;
use Blog\Infrastructure\UI\Web\WebApplication;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequestFactory;

class ProfileMiddlewareTest extends TestCase
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

    public function testProcess()
    {
        $start = microtime(true);

        /** @var HtmlResponse $response */
        $response = $this->app->run(ServerRequestFactory::fromGlobals([
            'REQUEST_URI' => '/',
            'REQUEST_METHOD' => 'GET',
        ]));

        self::assertNotEmpty($response->getBody()->getContents());
        self::assertEquals(200, $response->getStatusCode());
        $time = (float) $response->getHeaderLine('X-Profiler-Time');
        self::assertTrue($time > 0.0);
        self::assertTrue($time < (microtime(true) - $start));
    }
}
