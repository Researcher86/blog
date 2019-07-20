<?php

namespace Blog\Infrastructure\Application\Service;

use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\Before;
use Psr\Log\LoggerInterface;

class MonitorAspect implements Aspect
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * MonitorAspect constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    /**
     * Method that will be called before real method
     *
     * @param MethodInvocation $invocation Invocation
     * @Before("execution(public Blog\Application\**\**\*Service->execute(*))")
     */
    public function beforeMethodExecution(MethodInvocation $invocation)
    {
        $obj = $invocation->getThis();
        $this->logger->debug(
            implode("", [
                'Calling Before Interceptor for method: ',
                is_object($obj) ? get_class($obj) : $obj,
                $invocation->getMethod()->isStatic() ? '::' : '->',
                $invocation->getMethod()->getName(),
                '()',
                ' with arguments: ',
                json_encode($invocation->getArguments())
            ])
        );
    }
}
