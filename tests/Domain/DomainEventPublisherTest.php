<?php

declare(strict_types=1);

namespace Tests\Domain;

use BadMethodCallException;
use Blog\Domain\DomainEvent;
use Blog\Domain\DomainEventPublisher;
use Blog\Domain\DomainEventSubscriber;
use Blog\Domain\Model\Post\AddedCommentEvent;
use Blog\Domain\Model\Post\CommentId;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class DomainEventPublisherTest extends TestCase
{
    public function testClone()
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('Clone is not supported.');
        $domainEventPublisher = DomainEventPublisher::instance();

        $clone = clone $domainEventPublisher;
        self::assertNotNull($clone);
    }

    /**
     * @throws \Exception
     */
    public function testSubscribe()
    {
        $domainEventPublisher = DomainEventPublisher::instance();

        $subscribeId = $domainEventPublisher->subscribe(
            new class implements DomainEventSubscriber
            {
                public $lastEvent;

                public function __construct()
                {
                    $this->lastEvent = new class implements DomainEvent
                    {
                        public function occurredOn(): DateTimeImmutable
                        {
                        }
                    };
                }

                public function handle(DomainEvent $aDomainEvent): void
                {
                    $this->lastEvent = $aDomainEvent;
                }

                public function isSubscribedTo(DomainEvent $aDomainEvent): bool
                {
                    return true;
                }
            }
        );

        self::assertTrue($subscribeId >= 0);

        $domainEventSubscriber = $domainEventPublisher->ofId($subscribeId);
        assert($domainEventSubscriber !== null);
        assert(property_exists($domainEventSubscriber, 'lastEvent'));

        self::assertNotNull($domainEventSubscriber);

        $domainEventPublisher->publish(new AddedCommentEvent(new CommentId()));

        self::assertNotNull($domainEventSubscriber->lastEvent);
        self::assertNotNull($domainEventSubscriber->lastEvent->getCommentId());
        self::assertNotNull($domainEventSubscriber->lastEvent->occurredOn());
        self::assertInstanceOf(AddedCommentEvent::class, $domainEventSubscriber->lastEvent);
    }

    /**
     * @throws \Exception
     */
    public function testUnsubscribe()
    {
        $domainEventPublisher = DomainEventPublisher::instance();

        $subscribeId = $domainEventPublisher->subscribe(new class implements DomainEventSubscriber
        {
            public function handle(DomainEvent $aDomainEvent): void
            {
            }

            public function isSubscribedTo(DomainEvent $aDomainEvent): bool
            {
                return true;
            }
        });

        self::assertTrue($subscribeId >= 0);
        self::assertNotNull($domainEventPublisher->ofId($subscribeId));

        $domainEventPublisher->unsubscribe($subscribeId);
        self::assertNull($domainEventPublisher->ofId($subscribeId));
    }
}
