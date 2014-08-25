<?php

namespace Dolmen\Bundle\DolmenBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Dolmen\Bundle\DolmenBundle\DependencyInjection\DolmenExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Dolmen\Bundle\DolmenBundle\DependencyInjection\CompilerPass\ViewCompilerPass;
use Dolmen\Bundle\DolmenBundle\DependencyInjection\CompilerPass\RegisterCommandsCompilerPass;

/**
 * Dolmen framework bundle.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class DolmenBundle extends Bundle
{
    private $commandExplorer;

    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new DolmenExtension;
        }

        return $this->extension;
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ViewCompilerPass);
        $container->addCompilerPass(new RegisterCommandsCompilerPass);
    }

    /**
     * @return CommandExplorer
     */
    public function getCommandExplorer()
    {
    }
}
