<?php

namespace Blog\Infrastructure\Application\Service;

use Doctrine\ORM\EntityManagerInterface;
use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\Around;
use Psr\Log\LoggerInterface;

class DoctrineTransactionalAspect implements Aspect
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * MonitorAspect constructor.
     * @param LoggerInterface $logger
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }


    /**
     * Method that will be called before real method
     *
     * @param MethodInvocation $invocation Invocation
     * @Around("@execution(Blog\Infrastructure\Application\Transactional)")
     * @return mixed
     * @throws \Throwable
     */
    public function aroundMethodExecution(MethodInvocation $invocation)
    {
        return $this->entityManager->transactional(function () use ($invocation) {
            return $invocation->proceed();
        });
    }
}
