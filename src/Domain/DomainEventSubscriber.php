<?php

declare(strict_types=1);

namespace Blog\Domain;

interface DomainEventSubscriber
{
    public function handle(DomainEvent $aDomainEvent): void;

    public function isSubscribedTo(DomainEvent $aDomainEvent): bool;
}
