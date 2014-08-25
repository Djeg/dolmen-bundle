<?php

namespace Dolmen\Bundle\DolmenBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Dolmen\Bundle\DolmenBundle\DependencyInjection\Factory\ReferenceFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Register all "dolmen.command" tagged services inside the command launcher.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class RegisterCommandsCompilerPass implements CompilerPassInterface
{
    /**
     * @var ReferenceFactory
     */
    private $referenceFactory;

    /**
     * @param ReferenceFactory $referenceFactory
     */
    public function __construct(ReferenceFactory $referenceFactory = null)
    {
        $this->referenceFactory = $referenceFactory ?: new ReferenceFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('dolmen.launcher')) {
            return;
        }

        $definition = $container->getDefinition('dolmen.launcher');
        $taggedServices = $container->findTaggedServiceIds('dolmen.command');

        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall('addCommand', [
                $this->referenceFactory->create($id)
            ]);
        }
    }
}
