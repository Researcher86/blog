<?php

declare(strict_types=1);

namespace Blog\Infrastructure\UI\Web\Handler\Post;

use Blog\Application\Service\Post\PostService;
use Blog\Infrastructure\UI\Web\Template\ViewResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class GetPosts implements RequestHandlerInterface
{
    /**
     * @var PostService
     */
    private $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $posts = $this->postService->getAllPosts();
        return new ViewResponse('posts/list', ['posts' => $posts]);
    }
}
