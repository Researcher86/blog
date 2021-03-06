<?php

use Blog\Infrastructure\UI\Web\Middleware\AuthorMiddleware;
use Blog\Infrastructure\UI\Web\Middleware\BasicAuthMiddleware;
use Blog\Infrastructure\UI\Web\Middleware\ErrorMiddleware;
use Blog\Infrastructure\UI\Web\Middleware\ProfileMiddleware;
use Blog\Infrastructure\UI\Web\Middleware\TemplateRendererMiddleware;
use Zend\Stratigility\MiddlewarePipe;

return function (MiddlewarePipe $pipe) use ($container) {
    $pipeHelper = $container->get('pipe_helper');

    $pipeHelper($pipe, '*', ProfileMiddleware::class);
    $pipeHelper($pipe, '*', AuthorMiddleware::class);

    if (! $container->get('config')['debug']) {
        $pipeHelper($pipe, '*', ErrorMiddleware::class);
    }

    $pipeHelper($pipe, '/admin', BasicAuthMiddleware::class);
    $pipeHelper($pipe, '*', TemplateRendererMiddleware::class);
};
