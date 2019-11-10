<?php

declare(strict_types=1);

namespace Tests\Domain\Model;

use Blog\Domain\Model\Identity;
use DomainException;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactoryInterface;

class IdentityTest extends TestCase
{
    public function testCreate()
    {
        $identity = new class extends Identity{
        };
        self::assertNotEmpty($identity->id());
    }

    public function testCreateExpectDomainException()
    {
        $uuidFactory = Uuid::getFactory();
        $mockUuidFactory = $this->createMock(UuidFactoryInterface::class);
        $mockUuidFactory->expects(self::once())
            ->method('uuid4')
            ->willThrowException(new InvalidArgumentException('Test exception.'));
        assert($mockUuidFactory instanceof UuidFactoryInterface);
        Uuid::setFactory($mockUuidFactory);

        try {
            new class extends Identity {
            };
        } catch (Exception $exception) {
            self::assertEquals('Test exception.', $exception->getMessage());
            self::assertEquals(1, $exception->getCode());
            self::assertInstanceOf(DomainException::class, $exception);
            self::assertInstanceOf(InvalidArgumentException::class, $exception->getPrevious());
            Uuid::setFactory($uuidFactory);
            return;
        }
        self::fail();
    }
}
