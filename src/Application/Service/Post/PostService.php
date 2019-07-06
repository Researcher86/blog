<?php


namespace Blog\Application\Service\Post;


use Blog\Domain\Model\Post\Post;
use Blog\Domain\Model\Post\PostRepository;
use Blog\Domain\Model\User\UserId;

class PostService
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * PostService constructor.
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @param string $userId
     * @return Post[]
     */
    public function findPostsByUser(string $userId): array
    {
        return $this->postRepository->findByUser(new UserId($userId));
    }

    /**
     * @return Post[]
     */
    public function getAllPosts(): array
    {
        return $this->postRepository->getAll();
    }
}