<?php

declare(strict_types=1);

namespace Tests\Domain\Model\Post;

use Blog\Domain\Model\Post\Comment;
use Blog\Domain\Model\Post\CommentId;
use Blog\Domain\Model\Post\Post;
use Blog\Domain\Model\Post\PostId;
use Blog\Domain\Model\User\UserId;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    public function testCreate(): void
    {
        $comment = new Comment(
            $commentId = new CommentId(),
            $text = 'Text',
            $userId = new UserId(),
            $post = new Post(
                new PostId(),
                'Post name',
                new UserId()
            )
        );

        self::assertTrue($comment->getId()->equals($commentId));
        self::assertEquals($comment->getText(), $text);
        self::assertTrue($comment->getUserId()->equals($userId));
        self::assertTrue($comment->getUserId()->equals($userId));
        self::assertTrue($comment->getPost()->equals($post));
        self::assertTrue($comment->equals($comment));
    }

    public function testEquals(): void
    {
        $commentFirst = new Comment(
            $commentId = new CommentId(),
            $text = 'Text',
            $userId = new UserId(),
            $post = new Post(
                new PostId(),
                'Post name',
                new UserId()
            )
        );
        $commentSecond = clone $commentFirst;

        $commentThird = new Comment(
            $commentId = new CommentId(),
            $text = 'Text3',
            $userId = new UserId(),
            $post = new Post(
                new PostId(),
                'Post name3',
                new UserId()
            )
        );

        self::assertTrue($commentFirst->equals($commentSecond));
        self::assertFalse($commentFirst->equals($commentThird));
        self::assertFalse($commentSecond->equals($commentThird));
    }
}
