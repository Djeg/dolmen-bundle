<?php

namespace Dolmen\Bundle\DolmenBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Dolmen\Bundle\DolmenBundle\DependencyInjection\Factory\ReferenceFactory;

/**
 * Register all "dolmen.view" tagged services inside the view registry.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class ViewCompilerPass implements CompilerPassInterface
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
        if (!$container->hasDefinition('dolmen.registry.view_registry')) {
            return;
        }

        $definition     = $container->getDefinition('dolmen.registry.view_registry');
        $taggedServices = $container->findTaggedServiceIds('dolmen.view');

        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall('add', [
                $this->referenceFactory->create($id)
            ]);
        }
    }
}
