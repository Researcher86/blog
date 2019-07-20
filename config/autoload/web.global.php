<?php

use Aura\Router\Matcher;
use Aura\Router\RouterContainer;
use Blog\Infrastructure\UI\Web\Handler\NotFoundHandler;
use Blog\Infrastructure\UI\Web\Middleware\BasicAuthMiddleware;
use Blog\Infrastructure\UI\Web\Template\TemplateRenderInterface;
use Blog\Infrastructure\UI\Web\Template\Twig\TwigRender;
use Blog\Infrastructure\UI\Web\WebApplication;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;
use Zend\HttpHandlerRunner\Emitter\EmitterInterface;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use Zend\Stratigility\Middleware\PathMiddlewareDecorator;
use Zend\Stratigility\MiddlewarePipe;
use Zend\Stratigility\MiddlewarePipeInterface;

return [
    'dependencies' => [
        'factories' => [
            BasicAuthMiddleware::class => function (ContainerInterface $container, $requestedName) {
                return new BasicAuthMiddleware($container->get('config')['users']);
            },

            FilesystemLoader::class => function (ContainerInterface $container, $requestedName) {
                return new FilesystemLoader($container->get('config')['twig']['views']);
            },

            Environment::class => function (ContainerInterface $container, $requestedName) {
                return new Environment(
                    $container->get(LoaderInterface::class),
                    $container->get('config')['twig']
                );
            },

            'handlers' => function (ContainerInterface $container, $requestedName) {
                return include 'config/handlers.php';
            },
            'middlewares' => function (ContainerInterface $container, $requestedName) {
                return include 'config/middlewares.php';
            },

            'pipe_helper' => function (ContainerInterface $container, $requestedName) {
                return function (MiddlewarePipe $pipe, string $path, string $middleware) use ($container) {
                    if ($path === '*') {
                        $pipe->pipe($container->get($middleware));
                    } else {
                        $pipe->pipe(new PathMiddlewareDecorator($path, $container->get($middleware)));
                    }
                };
            },

            RouterContainer::class => function (ContainerInterface $container, $requestedName) {
                $routerContainer = new RouterContainer();

                $container->get('handlers')($routerContainer->getMap());

                return $routerContainer;
            },

            MiddlewarePipe::class => function (ContainerInterface $container, $requestedName) {
                $pipe = new MiddlewarePipe();

                $container->get('middlewares')($pipe);

                return $pipe;
            },

            Matcher::class => function (ContainerInterface $container, $requestedName) {
                return $container->get(RouterContainer::class)->getMatcher();
            },

            WebApplication::class => function (ContainerInterface $container, $requestedName) {
                return new WebApplication(
                    $container->get(MiddlewarePipeInterface::class),
                    $container->get(Matcher::class),
                    $container->get(RequestHandlerInterface::class),
                    $container->get(EmitterInterface::class),
                    $container
                );
            },
        ],

        'aliases' => [
            RequestHandlerInterface::class => NotFoundHandler::class,

            EmitterInterface::class => SapiEmitter::class,
            MiddlewarePipeInterface::class => MiddlewarePipe::class,
            TemplateRenderInterface::class => TwigRender::class,
            LoaderInterface::class => FilesystemLoader::class,
        ],
    ],

    'twig' => [
        'views' => [
            'src/Infrastructure/UI/Web/Template/Twig/Views'
        ],
        'debug' => true,
        'cache' => 'storage/cache/twig',
    ]
];
