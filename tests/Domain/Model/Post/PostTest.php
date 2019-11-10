<?php

declare(strict_types=1);

namespace Tests\Domain\Model\Post;

use Blog\Domain\Model\Post\Post;
use Blog\Domain\Model\Post\PostId;
use Blog\Domain\Model\User\UserId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    public function testCreate()
    {
        $post = new Post($postId = new PostId(), $name = 'Test', $userId = new UserId());
        self::assertTrue($post->getId()->equals($postId));
        self::assertTrue($post->getUserId()->equals($userId));
        self::assertEquals($post->getName(), $name);
    }

    public function testAddCommentExpectInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Text is required.');

        (new Post(new PostId(), 'Test', new UserId()))->addComment(
            '',
            new UserId()
        );
    }

    public function testAddComment()
    {
        $post = new Post(new PostId(), 'Test', new UserId());
        $post->addComment(' TEST ', new UserId());

        self::assertEquals('TEST', $post->getComments()[0]->getText());
    }
}
