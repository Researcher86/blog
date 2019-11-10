<?php

declare(strict_types=1);

namespace Blog\Infrastructure\UI\Web\Middleware;

use Blog\Infrastructure\UI\Web\Template\TemplateRender;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Zend\Diactoros\Response\HtmlResponse;

final class ErrorMiddleware implements MiddlewareInterface
{
    /**
     * @var TemplateRender
     */
    private $templateRender;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        TemplateRender $templateRender,
        LoggerInterface $logger
    ) {
        $this->templateRender = $templateRender;
        $this->logger = $logger;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        try {
            return $handler->handle($request);
        } catch (\Throwable $exception) {
            $this->logger->error(
                $exception->getMessage(),
                $exception->getTrace()
            );
            return $this->renderErrorPage($exception);
        }
    }

    private function renderErrorPage(\Throwable $exception): HtmlResponse
    {
        try {
            return new HtmlResponse(
                $this->templateRender->render(
                    'error',
                    ['error' => $exception]
                ),
                500
            );
        } catch (\Throwable $exception) {
            $this->logger->error(
                $exception->getMessage(),
                $exception->getTrace()
            );

            return new HtmlResponse('<h1>500 - Server Error</h1>', 500);
        }
    }
}
