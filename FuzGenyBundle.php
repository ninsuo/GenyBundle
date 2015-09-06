<?php

namespace Fuz\GenyBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FuzGenyBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new DependencyInjection\Compiler\LoaderCompilerPass());
        $container->addCompilerPass(new DependencyInjection\Compiler\UnserializerCompilerPass());
    }
}
