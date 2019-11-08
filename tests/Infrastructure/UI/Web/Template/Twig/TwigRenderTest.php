<?php

declare(strict_types=1);

namespace Tests\Infrastructure\UI\Web\Template\Twig;

use Blog\Infrastructure\UI\Web\Template\Twig\TwigRender;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigRenderTest extends TestCase
{
    public function testRender()
    {
        $twigRender = new TwigRender(new Environment(
            new FilesystemLoader([
                'tests/Infrastructure/UI/Web/Template/Twig/Views'
            ])
        ));

        $view = $twigRender->render('index', ['name' => 'Test']);

        self::assertStringContainsString('Test', $view);
    }
}
