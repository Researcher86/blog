<?php


namespace Blog\Infrastructure\UI\Web\Middleware;

use Blog\Infrastructure\UI\Web\Template\TemplateRenderInterface;
use Blog\Infrastructure\UI\Web\Template\ViewResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;

class TemplateRendererMiddleware implements MiddlewareInterface
{
    /**
     * @var TemplateRenderInterface
     */
    private $templateRender;


    /**
     * RenderPageMiddleware constructor.
     * @param TemplateRenderInterface $templateRender
     */
    public function __construct(TemplateRenderInterface $templateRender)
    {
        $this->templateRender = $templateRender;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        if ($response instanceof ViewResponse) {
            return new HtmlResponse(
                $this->templateRender->render($response->getName(), $response->getData()),
                $response->getStatusCode(),
                $response->getHeaders()
            );
        }

        return $response;
    }
}
