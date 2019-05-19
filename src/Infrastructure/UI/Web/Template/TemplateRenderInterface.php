<?php


namespace Blog\Infrastructure\UI\Web\Template;


interface TemplateRenderInterface
{
    public function render(string $path, array $data): string;
}