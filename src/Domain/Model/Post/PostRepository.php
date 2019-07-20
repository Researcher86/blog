<?php


namespace Blog\Domain\Model\Post;

use Blog\Domain\Model\User\UserId;

interface PostRepository
{
    /**
     * @return Post[]
     */
    public function getAll();

    /**
     * @return PostId
     */
    public function nextIdentity(): PostId;

    /**
     * @param UserId $userId
     * @return Post[]
     */
    public function findByUser(UserId $userId): array;

    /**
     * @param PostId $param
     * @return null|Post
     */
    public function findById(PostId $param): ?Post;
}
