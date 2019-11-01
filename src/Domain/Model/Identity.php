<?php

declare(strict_types=1);

namespace Blog\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * Class Identity
 *
 * @package Blog\Domain\Model
 *
 * @ORM\MappedSuperclass()
 */
abstract class Identity
{
    /**
     * @var string
     *
     * @ORM\Id
     *
     * @ORM\Column(type="guid")
     */
    protected $id;

    public function __construct(?string $id = null)
    {
        try {
            $this->id = $id ?? Uuid::uuid4()->toString();
        } catch (\Exception $exception) {
            throw new \RuntimeException(
                $exception->getMessage(),
                1,
                $exception
            );
        }
    }

    public function equals(Identity $identity): bool
    {
        return $this->id === $identity->id;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id;
    }

    public function id(): string
    {
        return $this->id;
    }
}
