<?php

declare(strict_types=1);

namespace Blog\Domain\Model\Post;

use Blog\Domain\Model\User\UserId;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 *
 * @ORM\Table(name="blog_comments")
 */
final class Comment
{
    /**
     * @var CommentId
     *
     * @ORM\Embedded(class="CommentId", columnPrefix=false)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $text;

    /**
     * @var UserId
     *
     * @ORM\Embedded(class="Blog\Domain\Model\User\UserId", columnPrefix="user_")
     */
    private $userId;

    /**
     * @var Post
     *
     * @ORM\ManyToOne(targetEntity="Post")
     */
    private $post;

    public function __construct(
        CommentId $id,
        string $text,
        UserId $userId,
        Post $post
    ) {
        $this->id = $id;
        $this->text = $text;
        $this->userId = $userId;
        $this->post = $post;
    }

    public function getId(): CommentId
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getPost(): Post
    {
        return $this->post;
    }

    public function equals(Comment $other): bool
    {
        return $this->id->equals($other->id);
    }
}
