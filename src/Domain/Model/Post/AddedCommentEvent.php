<?php

declare(strict_types=1);

namespace Blog\Domain\Model\Post;

use Blog\Domain\DomainEvent;
use DateTimeImmutable;

final class AddedCommentEvent implements DomainEvent
{
    /**
     * @var CommentId
     */
    private $commentId;
    /**
     * @var DateTimeImmutable
     */
    private $date;

    /**
     * AddedCommentEvent constructor.
     *
     * @param CommentId $commentId
     *
     * @throws \Exception
     */
    public function __construct(CommentId $commentId)
    {
        $this->commentId = $commentId;
        $this->date = new DateTimeImmutable();
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getCommentId(): CommentId
    {
        return $this->commentId;
    }
}
