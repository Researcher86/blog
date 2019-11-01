<?php

declare(strict_types=1);

namespace Blog\Domain\Model\User;

use Blog\Domain\Model\Identity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
final class UserId extends Identity
{
}
