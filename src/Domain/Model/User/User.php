<?php

declare(strict_types=1);

namespace Blog\Domain\Model\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 *
 * @ORM\Table(name="blog_users")
 */
final class User
{
    /**
     * @var UserId
     *
     * @ORM\Embedded(class="UserId", columnPrefix=false)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $age;

    public function __construct(UserId $userId, string $name, int $age)
    {
        $this->id = $userId;
        $this->name = $name;
        $this->age = $age;
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function equals(User $user): bool
    {
        return $this->id->equals($user->id);
    }
}
