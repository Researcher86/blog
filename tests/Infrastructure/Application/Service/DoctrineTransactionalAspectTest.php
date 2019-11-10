<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Application\Service;

use Blog\Infrastructure\Application\Service\DoctrineTransactionalAspect;
use Doctrine\ORM\EntityManagerInterface;
use DomainException;
use Go\Aop\Intercept\MethodInvocation;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class DoctrineTransactionalAspectTest extends TestCase
{
    /**
     * @var DoctrineTransactionalAspect
     */
    private $aspect;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $entityManager;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $logger;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $methodInvocation;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);

        assert($this->entityManager instanceof EntityManagerInterface);
        assert($this->logger instanceof LoggerInterface);

        $this->aspect = new DoctrineTransactionalAspect($this->logger, $this->entityManager);
        $this->methodInvocation = $this->createMock(MethodInvocation::class);
    }

    /**
     * @throws \Exception
     */
    public function testTransactionCommit(): void
    {
        $this->entityManager->expects(self::once())->method('beginTransaction');
        $this->entityManager->expects(self::once())->method('flush');
        $this->entityManager->expects(self::once())->method('commit');
        $this->methodInvocation->expects(self::once())->method('proceed');
        assert($this->methodInvocation instanceof MethodInvocation);

        $this->aspect->transaction($this->methodInvocation);
    }

    /**
     * @throws \Exception
     */
    public function testTransactionRollBack(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Logical exception.');
        $this->entityManager->expects(self::once())->method('beginTransaction');
        $this->entityManager->expects(self::never())->method('flush');
        $this->entityManager->expects(self::never())->method('commit');
        $this->entityManager->expects(self::once())->method('rollBack');
        $this->logger->expects(self::once())->method('error');

        $this->methodInvocation->expects(self::once())
            ->method('proceed')
            ->willThrowException(new DomainException('Logical exception.'));
        assert($this->methodInvocation instanceof MethodInvocation);

        $this->aspect->transaction($this->methodInvocation);
    }
}
