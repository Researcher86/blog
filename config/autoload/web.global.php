<?php

use Aura\Router\Map;
use Aura\Router\Matcher;
use Aura\Router\RouterContainer;
use Blog\Infrastructure\UI\Web\Handler\AboutHandler;
use Blog\Infrastructure\UI\Web\Handler\GetAllUsersHandler;
use Blog\Infrastructure\UI\Web\Handler\IndexHandler;
use Blog\Infrastructure\UI\Web\Handler\NotFoundHandler;
use Blog\Infrastructure\UI\Web\Handler\ProfileHandler;
use Blog\Infrastructure\UI\Web\Handler\ShowHandler;
use Blog\Infrastructure\UI\Web\Middleware\AuthorMiddleware;
use Blog\Infrastructure\UI\Web\Middleware\BasicAuthMiddleware;
use Blog\Infrastructure\UI\Web\Middleware\ErrorMiddleware;
use Blog\Infrastructure\UI\Web\Middleware\ProfileMiddleware;
use Blog\Infrastructure\UI\Web\Middleware\TemplateRendererMiddleware;
use Blog\Infrastructure\UI\Web\Template\TemplateRenderInterface;
use Blog\Infrastructure\UI\Web\Template\Twig\TwigRenderInterface;
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
                return function (Map $map) {
                    $map->get('home', '/', IndexHandler::class);
                    $map->get('users', '/users', GetAllUsersHandler::class);
                    $map->get('about', '/about', AboutHandler::class);
                    $map->get('profile', '/profile', ProfileHandler::class);
                    $map->get('show', '/show/{id}', ShowHandler::class)->tokens(['id' => '\d+']);
                };
            },
            'middlewares' => function (ContainerInterface $container, $requestedName) {
                return function (MiddlewarePipe $pipe) use ($container) {
                    $pipeHelper = $container->get('pipe_helper');

                    $pipeHelper($pipe, '*', ProfileMiddleware::class);
                    $pipeHelper($pipe, '*', AuthorMiddleware::class);
                    $pipeHelper($pipe, '*', ErrorMiddleware::class);
                    $pipeHelper($pipe, '/profile', BasicAuthMiddleware::class);
                    $pipeHelper($pipe, '*', TemplateRendererMiddleware::class);
                };
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
            TemplateRenderInterface::class => TwigRenderInterface::class,
            LoaderInterface::class => FilesystemLoader::class,
        ],
    ],

    'twig' => [
        'views' => [
            'src/Infrastructure/UI/Web/Template/Twig/Views'
        ],
        'debug' => false,
        'cache' => 'storage/cache/twig',
    ]
];