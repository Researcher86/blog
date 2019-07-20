<?php


namespace Blog\Infrastructure\UI\Web\Middleware;

use Blog\Infrastructure\UI\Web\Template\TemplateRenderInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Zend\Diactoros\Response\HtmlResponse;

class ErrorMiddleware implements MiddlewareInterface
{
    /**
     * @var TemplateRenderInterface
     */
    private $templateRender;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Error404Middleware constructor.
     * @param TemplateRenderInterface $templateRender
     * @param LoggerInterface $logger
     */
    public function __construct(TemplateRenderInterface $templateRender, LoggerInterface $logger)
    {
        $this->templateRender = $templateRender;
        $this->logger = $logger;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage(), $e->getTrace());
            try {
                return new HtmlResponse($this->templateRender->render('error', ['error' => $e]), 500);
            } catch (\Throwable $e) {
                $this->logger->error($e->getMessage(), $e->getTrace());
                return new HtmlResponse('<h1>500 - Server Error</h1>', 500);
            }
        }
    }
}
