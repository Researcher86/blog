<?php

declare(strict_types=1);

namespace Blog\Domain;

interface DomainEvent
{
    public function occurredOn(): \DateTimeImmutable;
}
