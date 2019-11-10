<?php

declare(strict_types=1);

namespace Tests\Infrastructure\UI\Web\Handler;

use Blog\Infrastructure\UI\Web\WebApplication;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequestFactory;

class NotFoundHandlerTest extends TestCase
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

    public function testHandle()
    {
        /** @var HtmlResponse $response */
        $response = $this->app->run(ServerRequestFactory::fromGlobals([
            'REQUEST_URI' => '/test123',
            'REQUEST_METHOD' => 'GET',
        ]));

        self::assertNotEmpty($response->getBody()->getContents());
        self::assertEquals(404, $response->getStatusCode());
    }
}
