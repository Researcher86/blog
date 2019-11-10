<?php

declare(strict_types=1);

namespace Blog\Infrastructure\UI\Web\Template;

interface TemplateRender
{
    /**
     * Render view.
     *
     * @param string $viewName View name
     * @param array<string, string|int|float|bool|object|array> $data
     *  Variables for view
     *
     * @return string
     */
    public function render(string $viewName, array $data): string;
}
