<?php

declare(strict_types=1);

namespace Blog\Domain;

use BadMethodCallException;

final class DomainEventPublisher
{
    /**
     * @var array<DomainEventSubscriber>
     */
    private $subscribers;

    /**
     * @var DomainEventPublisher
     */
    private static $instance = null;

    /**
     * @var int
     */
    private $id = 0;

    public static function instance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $this->subscribers = [];
    }

    public function __clone()
    {
        throw new BadMethodCallException('Clone is not supported.');
    }

    public function subscribe(DomainEventSubscriber $subscriber): int
    {
        $this->subscribers[$this->id] = $subscriber;
        $id = $this->id;
        $this->id++;
        return $id;
    }

    public function ofId(int $id): ?DomainEventSubscriber
    {
        return $this->subscribers[$id] ?? null;
    }

    public function unsubscribe(int $id): void
    {
        unset($this->subscribers[$id]);
    }

    public function publish(DomainEvent $domainEvent): void
    {
        foreach ($this->subscribers as $subscriber) {
            if ($subscriber->isSubscribedTo($domainEvent)) {
                $subscriber->handle($domainEvent);
            }
        }
    }
}
