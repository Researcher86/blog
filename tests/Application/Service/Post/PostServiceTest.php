<?php

namespace Tests\Application\Service\Post;

use Blog\Application\Service\Post\PostService;
use Blog\Domain\Model\Post\Post;
use Blog\Domain\Model\Post\PostId;
use Blog\Domain\Model\Post\PostRepository;
use Blog\Domain\Model\User\UserId;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class PostServiceTest
 * @package Blog\Application\Service\Post
 */
class PostServiceTest extends TestCase
{
    /**
     * @var PostService
     */
    private $postService;
    /**
     * @var MockObject
     */
    private $postRepository;

    /**
     * @var Post[]
     */
    private $posts;

    /**
     * @throws \ReflectionException
     */
    protected function setUp(): void
    {
        $this->posts = [
            new Post(new PostId('7afcd67d-790d-48c4-9922-0a085f5d27ac'), 'Post', new UserId('7afcd67d-790d-48c4-9922-0a085f5d27ac')),
            new Post(new PostId('7afcd67d-790d-48c4-9923-0a085f5d27ac'), 'Post', new UserId('7afcd67d-790d-48c4-9922-0a085f5d27ac')),
        ];

        $this->postRepository = $this->createMock(PostRepository::class);
        $this->postService = new PostService($this->postRepository);
    }


    public function testFindPostsByUser()
    {
        $this->postRepository->method('getAll')->willReturn($this->posts);
        $posts = $this->postService->getAllPosts();
        self::assertEquals($this->posts, $posts);
    }

    public function testGetAllPosts()
    {
        $this->postRepository->method('findByUser')->willReturn([$this->posts[0]]);
        $posts = $this->postService->findPostsByUser('7afcd67d-790d-48c4-9922-0a085f5d27ac');
        self::assertEquals($this->posts[0], $posts[0]);
    }
}
