<?php

declare(strict_types=1);

namespace Tests\Infrastructure\UI\Web\Template\Php;

use Blog\Infrastructure\UI\Web\Template\Php\PhpRender;
use PHPUnit\Framework\TestCase;

class PhpRenderTest extends TestCase
{
    public function testRender()
    {
        $phpRender = new PhpRender(__DIR__ . '/Views');

        $view = $phpRender->render('index', ['name' => 'Test']);

        self::assertStringContainsString('Test', $view);
    }

    public function testRenderReturnException()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Error render view.');

        $phpRender = new PhpRender(__DIR__ . '/Views');
        $phpRender->render('index2', ['name' => 'Test']);
    }
}
