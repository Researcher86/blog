<?php

declare(strict_types=1);

namespace Blog\Domain\Model\Post;

use Blog\Domain\Model\User\UserId;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

/**
 * @ORM\Entity()
 *
 * @ORM\Table(name="blog_posts")
 */
final class Post
{
    /**
     * @var PostId
     *
     * @ORM\Embedded(class="PostId", columnPrefix=false)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var UserId
     *
     * @ORM\Embedded(class="Blog\Domain\Model\User\UserId", columnPrefix="user_")
     */
    private $userId;

    /**
     * @var array<Comment>
     *
     * @ORM\OneToMany(
     *     targetEntity="Comment",
     *     mappedBy="Post",
     *     cascade={"remove", "persist"}
     * )
     */
    private $comments = [];

    public function __construct(PostId $id, string $name, UserId $userId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->userId = $userId;
    }

    public function getId(): PostId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return array<Comment>
     */
    public function getComments(): array
    {
        return $this->comments;
    }

    public function addComment(string $text, UserId $userId): void
    {
        $msg = trim($text);
        if ($msg === '') {
            throw new InvalidArgumentException('Text is required.');
        }

        $this->comments[] = new Comment(new CommentId(), $msg, $userId, $this);
    }

    public function equals(Post $other): bool
    {
        return $this->id->equals($other->id);
    }
}
