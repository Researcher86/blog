<?php


namespace Blog\Infrastructure\UI\Web\Template;

interface TemplateRenderInterface
{
    /**
     * @param string $path
     * @param array $data
     * @return string
     */
    public function render(string $path, array $data): string;
}
