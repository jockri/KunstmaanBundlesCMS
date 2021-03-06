<?php

namespace Kunstmaan\UtilitiesBundle\Tests\DependencyInjection\Compiler;

use Kunstmaan\UtilitiesBundle\DependencyInjection\Compiler\DeprecateClassParametersPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class DeprecateClassParametersPassTest extends AbstractCompilerPassTestCase
{
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new DeprecateClassParametersPass());
    }

    /**
     * @group legacy
     * @expectedDeprecation Using the "kunstmaan_utilities.slugifier.class" parameter to change the class of the service definition is deprecated in KunstmaanUtilitiesBundle 5.2 and will be removed in KunstmaanUtilitiesBundle 6.0. Use service decoration or a service alias instead.
     */
    public function testServiceClassParameterOverride()
    {
        $this->setParameter('kunstmaan_utilities.slugifier.class', 'Custom\Class');

        $this->compile();
    }
}
