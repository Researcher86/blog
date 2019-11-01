<?php

declare(strict_types=1);

namespace Blog\Infrastructure\Application;

use Go\Core\AspectContainer;
use Go\Core\AspectKernel;
use Psr\Container\ContainerInterface;

final class ApplicationAspectKernel extends AspectKernel
{
    /**
     * @var ContainerInterface
     */
    private $diContainer;

    public function setDiContainer(ContainerInterface $container): void
    {
        $this->diContainer = $container;
    }

    protected function configureAop(AspectContainer $container): void
    {
        foreach ($this->diContainer->get('aspects') as $aspect) {
            $container->registerAspect($aspect);
        }
    }
}
