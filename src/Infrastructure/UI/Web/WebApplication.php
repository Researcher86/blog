<?php

declare(strict_types=1);

namespace Blog\Infrastructure\UI\Web;

use Aura\Router\Matcher;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Stratigility\MiddlewarePipeInterface;

final class WebApplication
{
    /**
     * @var MiddlewarePipeInterface
     */
    private $middlewarePipe;
    /**
     * @var Matcher
     */
    private $matcher;
    /**
     * @var RequestHandlerInterface
     */
    private $defaultHandler;
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(
        MiddlewarePipeInterface $middlewarePipe,
        Matcher $matcher,
        RequestHandlerInterface $defaultHandler,
        ContainerInterface $container
    ) {
        $this->middlewarePipe = $middlewarePipe;
        $this->matcher = $matcher;
        $this->defaultHandler = $defaultHandler;
        $this->container = $container;
    }

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $matcher = $this->matcher;

        $route = $matcher->match($request);
        if ($route) {
            $callable = $this->container->get($route->handler);

            foreach ($route->attributes as $key => $val) {
                $request = $request->withAttribute($key, $val);
            }
        } else {
            $callable = $this->defaultHandler;
        }

        return $this->middlewarePipe->process($request, $callable);
    }
}
