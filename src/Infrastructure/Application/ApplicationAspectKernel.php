<?php

namespace Blog\Infrastructure\Application;

use Go\Core\AspectContainer;
use Go\Core\AspectKernel;
use Psr\Container\ContainerInterface;

class ApplicationAspectKernel extends AspectKernel
{
    /**
     * @var ContainerInterface
     */
    private $diContainer;

    /**
     * @param ContainerInterface $container
     */
    public function setDiContainer(ContainerInterface $container): void
    {
        $this->diContainer = $container;
    }


    /**
     * Configure an AspectContainer with advisors, aspects and pointcuts
     *
     * @param AspectContainer $container
     *
     * @return void
     */
    protected function configureAop(AspectContainer $container)
    {
        foreach ($this->diContainer->get('aspects') as $aspect) {
            $container->registerAspect($aspect);
        }

    }
}