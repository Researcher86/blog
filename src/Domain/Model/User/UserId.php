<?php


namespace Blog\Domain\Model\User;

use Blog\Domain\Model\Identity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class UserId extends Identity
{
}
