<?php

declare(strict_types=1);

namespace Blog\Infrastructure\Application\Service;

use Doctrine\ORM\EntityManagerInterface;
use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\Around;
use Psr\Log\LoggerInterface;
use Throwable;

final class DoctrineTransactionalAspect implements Aspect
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        LoggerInterface $logger,
        EntityManagerInterface $entityManager
    ) {
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }


    /**
     * @param MethodInvocation $invocation Invocation
     *
     * @Around("@execution(Blog\Infrastructure\Application\Transactional)")
     *
     * @return object|null
     *
     * @throws \Throwable
     */
    public function aroundMethodExecution(MethodInvocation $invocation): ?object
    {
        $this->entityManager->beginTransaction();

        try {
            $return = $invocation->proceed();
            $this->entityManager->flush();
            $this->entityManager->commit();

            return $return;
        } catch (Throwable $exception) {
            $this->entityManager->rollBack();

            $this->logger->error(
                $exception->getMessage(),
                $exception->getTrace()
            );

            return null;
        }
    }
}
