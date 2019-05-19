<?php


namespace Blog\Domain;


interface DomainEvent
{
    /**
     * @return \DateTime
     */
    public function occurredOn();
}