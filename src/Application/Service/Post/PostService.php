<?php


namespace Blog\Application\Service\Post;

use Blog\Domain\Model\Post\Post;
use Blog\Domain\Model\Post\PostId;
use Blog\Domain\Model\Post\PostNotFountException;
use Blog\Domain\Model\Post\PostRepository;
use Blog\Domain\Model\User\UserId;
use Blog\Infrastructure\Application\Transactional;

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

    /**
     * @Transactional()
     * @param string $text
     * @param string $userId
     * @param string $postId
     */
    public function addComment(string $text, string $userId, string $postId)
    {
        $post = $this->postRepository->findById(new PostId($postId));

        if (!$post) {
            throw new PostNotFountException("Post not fount.");
        }

        $post->addComment($text, new UserId($userId));
    }
}
