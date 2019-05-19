<?php

namespace Blog\Infrastructure\UI\Web;

use Aura\Router\Matcher;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\HttpHandlerRunner\Emitter\EmitterInterface;
use Zend\Stratigility\MiddlewarePipe;
use Zend\Stratigility\MiddlewarePipeInterface;

class WebApplication
{
    /**
     * @var MiddlewarePipe
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
    /**
     * @var EmitterInterface
     */
    private $emitter;


    /**
     * WebApplication constructor.
     * @param MiddlewarePipeInterface $middlewarePipe
     * @param Matcher $matcher
     * @param RequestHandlerInterface $defaultHandler
     * @param EmitterInterface $emitter
     * @param ContainerInterface $container
     */
    public function __construct(MiddlewarePipeInterface $middlewarePipe,
                                Matcher $matcher,
                                RequestHandlerInterface $defaultHandler,
                                EmitterInterface $emitter,
                                ContainerInterface $container)
    {
        $this->middlewarePipe = $middlewarePipe;
        $this->matcher = $matcher;
        $this->defaultHandler = $defaultHandler;
        $this->emitter = $emitter;
        $this->container = $container;
    }

    public function run(ServerRequestInterface $request)
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

        $response = $this->middlewarePipe->process($request, $callable);
        $this->emitter->emit($response);
    }
}