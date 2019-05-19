<?php


namespace Blog\Domain\Model\User;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="blog_users")
 */
class User
{
    /**
     * @ORM\Embedded(class="Blog\Domain\Model\User\UserId", columnPrefix=false)
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * User constructor.
     * @param UserId $userId
     * @param string $name
     * @param int $age
     */
    public function __construct(UserId $userId, string $name, int $age)
    {
        $this->id = $userId;
        $this->name = $name;
        $this->age = $age;
    }

    /**
     * @return UserId
     */
    public function getId(): UserId
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
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

}