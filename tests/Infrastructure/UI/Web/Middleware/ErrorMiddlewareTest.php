<?php

declare(strict_types=1);

namespace Tests\Infrastructure\UI\Web\Middleware;

use Blog\Infrastructure\UI\Web\Middleware\ErrorMiddleware;
use Blog\Infrastructure\UI\Web\Template\TemplateRender;
use Blog\Infrastructure\UI\Web\Template\ViewResponse;
use Exception;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Zend\Diactoros\Response\HtmlResponse;

class ErrorMiddlewareTest extends TestCase
{
    /**
     * @var ErrorMiddleware
     */
    private $errorMiddleware;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $templateRender;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $logger;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $request;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $handler;

    protected function setUp(): void
    {
        $this->templateRender = $this->createMock(TemplateRender::class);
        $this->logger = $this->createMock(LoggerInterface::class);

        assert($this->templateRender instanceof TemplateRender);
        assert($this->logger instanceof LoggerInterface);

        $this->errorMiddleware = new ErrorMiddleware(
            $this->templateRender,
            $this->logger
        );

        $this->request = $this->createMock(ServerRequestInterface::class);
        $this->handler = $this->createMock(RequestHandlerInterface::class);
    }

    public function testProcess(): void
    {
        $this->handler->method('handle')->willReturn(new ViewResponse('error', [], 500));
        assert($this->request instanceof ServerRequestInterface);
        assert($this->handler instanceof RequestHandlerInterface);

        $response = $this->errorMiddleware->process($this->request, $this->handler);

        self::assertInstanceOf(ViewResponse::class, $response);
        self::assertEquals(500, $response->getStatusCode());
    }

    public function testProcessHandlerThrowException(): void
    {
        $this->logger->expects(self::once())->method('error');
        $this->templateRender->expects(self::once())
            ->method('render')
            ->with(
                $this->equalTo('error'),
                $this->callback(function ($o) {
                    return array_key_exists('error', $o) && $o['error'] instanceof Exception;
                }),
            );
        $this->handler->method('handle')->willThrowException(new Exception());
        assert($this->request instanceof ServerRequestInterface);
        assert($this->handler instanceof RequestHandlerInterface);

        $response = $this->errorMiddleware->process($this->request, $this->handler);

        self::assertInstanceOf(HtmlResponse::class, $response);
        self::assertEquals(500, $response->getStatusCode());
    }

    public function testProcessHandlerThrowExceptionAndRenderThrowException(): void
    {
        $this->logger->expects(self::exactly(2))->method('error');
        $this->templateRender->expects(self::once())
            ->method('render')
            ->willThrowException(new Exception());
        $this->handler->method('handle')->willThrowException(new Exception());
        assert($this->request instanceof ServerRequestInterface);
        assert($this->handler instanceof RequestHandlerInterface);

        $response = $this->errorMiddleware->process($this->request, $this->handler);

        self::assertInstanceOf(HtmlResponse::class, $response);
        self::assertEquals(500, $response->getStatusCode());
        self::assertEquals('<h1>500 - Server Error</h1>', $response->getBody()->getContents());
    }
}
