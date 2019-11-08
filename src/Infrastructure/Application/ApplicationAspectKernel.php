<?php

declare(strict_types=1);

namespace Blog\Infrastructure\Application;

use Go\Core\AspectContainer;
use Go\Core\AspectKernel;

final class ApplicationAspectKernel extends AspectKernel
{

    protected function configureAop(AspectContainer $container): void
    {
    }
}
