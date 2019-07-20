<?php


namespace Blog\Infrastructure\UI\Web\Template\Twig;

use Blog\Infrastructure\UI\Web\Template\TemplateRenderInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\ArrayLoader;
use Twig\Loader\FilesystemLoader;

class TwigRender implements TemplateRenderInterface
{
    /**
     * @var Environment
     */
    private $environment;


    /**
     * TwigRenderInterface constructor.
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    public function render(string $path, array $data): string
    {
        if ($this->environment->isDebug()) {
            $this->environment->addExtension(new DebugExtension());
        }

        return $this->environment->render($path . '.twig', $data);
    }
}
