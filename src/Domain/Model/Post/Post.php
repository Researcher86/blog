<?php


namespace Blog\Domain\Model\Post;

use Blog\Domain\Model\User\UserId;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="blog_posts")
 */
class Post
{
    /**
     * @var PostId
     * @ORM\Embedded(class="PostId", columnPrefix=false)
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var UserId
     * @ORM\Embedded(class="Blog\Domain\Model\User\UserId", columnPrefix="user_")
     */
    private $userId;

    /**
     * Post constructor.
     * @param PostId $id
     * @param string $name
     * @param UserId $userId
     */
    public function __construct(PostId $id, string $name, UserId $userId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->userId = $userId;
    }

    /**
     * @return PostId
     */
    public function getId(): PostId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }
}