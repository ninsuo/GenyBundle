<?php

namespace Fuz\GenyBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FuzGenyBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new DependencyInjection\Compiler\ExtensionCompilerPass());
        $container->addCompilerPass(new DependencyInjection\Compiler\LoaderCompilerPass());
        $container->addCompilerPass(new DependencyInjection\Compiler\UnserializerCompilerPass());
        $container->addCompilerPass(new DependencyInjection\Compiler\NormalizerCompilerPass());
        $container->addCompilerPass(new DependencyInjection\Compiler\ValidatorCompilerPass());
    }
}
