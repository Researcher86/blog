<?php


namespace Blog\Domain\Model\Post;


use Blog\Domain\Model\Identity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class PostId extends Identity
{

}