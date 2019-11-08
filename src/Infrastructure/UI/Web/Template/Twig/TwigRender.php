<?php

declare(strict_types=1);

namespace Blog\Infrastructure\UI\Web\Template\Twig;

use Blog\Infrastructure\UI\Web\Template\TemplateRender;
use Twig\Environment;

final class TwigRender implements TemplateRender
{
    /**
     * @var Environment
     */
    private $environment;

    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * {@inheritDoc}
     */
    public function render(string $viewName, array $data): string
    {
        return $this->environment->render($viewName . '.twig', $data);
    }
}
