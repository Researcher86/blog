<?php

declare(strict_types=1);

namespace Tests\Infrastructure\UI\Web\Handler\Post;

use Blog\Infrastructure\UI\Web\WebApplication;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequestFactory;

class GetPostsTest extends TestCase
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
            'REQUEST_URI' => '/posts',
            'REQUEST_METHOD' => 'GET',
        ]));

        $content = $response->getBody()->getContents();
        self::assertNotEmpty($content);
        self::assertEquals(200, $response->getStatusCode());
        self::assertStringContainsString('11111111-1111-1111-1111-111111111111', $content);
    }
}
