<?php

namespace Dolmen\Bundle\DolmenBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Configure the bundle.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $tree = new TreeBuilder;

        $tree->root('dolmen');

        return $tree;
    }
}
