<?php

declare(strict_types=1);

namespace Blog\Infrastructure\UI\Web\Template\Php;

use Blog\Infrastructure\UI\Web\Template\TemplateRender;

final class PhpRender implements TemplateRender
{
    /**
     * @var string
     */
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * {@inheritDoc}
     */
    public function render(string $viewName, array $data): string
    {
        $result = null;

        if (ob_start()) {
            extract($data);
            @include sprintf('%s/%s.php', $this->path, $viewName);
            $result = ob_get_clean();
        }

        if (! $result) {
            throw new \RuntimeException('Error render view.');
        }

        return $result;
    }
}
