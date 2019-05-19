<?php


namespace Blog\Domain\Model;


use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * Class Identity
 * @package Blog\Domain\Model
 *
 * @ORM\MappedSuperclass()
 */
abstract class Identity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="guid")
     */
    protected $id;

    /**
     * Identity constructor.
     * @param string $id
     */
    public function __construct(string $id = null)
    {
        $this->id = $id ?? Uuid::uuid4()->toString();
    }

    public function equals(Identity $identity)
    {
        return $this->id === $identity->id;
    }

    public function __toString()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

}