<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Application\Service;

use Blog\Infrastructure\Application\Service\MonitorAspect;
use Go\Aop\Intercept\MethodInvocation;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use ReflectionMethod;

class MonitorAspectTest extends TestCase
{

    public function testMonitor()
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects(self::once())
            ->method('debug')
            ->with(self::equalTo(
                'Calling Before Interceptor for method: ::method() with arguments: [1,2,3]'
            ));
        assert($logger instanceof LoggerInterface);

        $reflectionMethod = $this->createMock(ReflectionMethod::class);
        $reflectionMethod->expects(self::once())->method('isStatic')->willReturn(true);
        $reflectionMethod->expects(self::once())->method('getName')->willReturn('method');

        $methodInvocation = $this->createMock(MethodInvocation::class);
        $methodInvocation->expects(self::once())->method('getArguments')->willReturn([1, 2, 3]);
        $methodInvocation->expects(self::exactly(2))
            ->method('getMethod')
            ->willReturn(
                $reflectionMethod
            );
        assert($methodInvocation instanceof MethodInvocation);

        $aspect = new MonitorAspect($logger);
        $aspect->monitor($methodInvocation);
    }
}
