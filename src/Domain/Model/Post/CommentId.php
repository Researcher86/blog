<?php
declare(strict_types=1);

namespace Blog\Domain\Model\Post;

use Blog\Domain\Model\Identity;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Embeddable()
 */
class CommentId extends Identity
{

}