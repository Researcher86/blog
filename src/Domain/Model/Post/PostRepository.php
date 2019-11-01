<?php

declare(strict_types=1);

namespace Blog\Domain\Model\Post;

use Blog\Domain\Model\User\UserId;

interface PostRepository
{
    /**
     * @return Post[]
     */
    public function getAll(): array;

    public function nextIdentity(): PostId;

    /**
     * @return Post[]
     */
    public function findByUser(UserId $userId): array;

    public function findById(PostId $param): ?Post;
}
