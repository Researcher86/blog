<?php

namespace Blog\Infrastructure\UI\Web\Handler\Post;

use Blog\Application\Service\Post\PostService;
use Blog\Infrastructure\UI\Web\Template\ViewResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetPostsByUser implements RequestHandlerInterface
{
    /**
     * @var PostService
     */
    private $postService;

    /**
     * GetAllPostByUser constructor.
     * @param PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $posts = $this->postService->findPostsByUser($request->getAttribute('userId'));
        return new ViewResponse('posts/list', ['posts' => $posts]);
    }
}
