<?php

namespace Tests\Domain;


use Blog\Domain\DomainEventPublisher;
use PHPUnit\Framework\TestCase;

class DomainEventDispatcherTest extends TestCase
{

    public function testGetInstance()
    {
        self::assertNotNull($instance1 = DomainEventPublisher::instance());
        self::assertNotNull($instance2 = DomainEventPublisher::instance());

        self::assertEquals($instance1, $instance2);
    }
}
