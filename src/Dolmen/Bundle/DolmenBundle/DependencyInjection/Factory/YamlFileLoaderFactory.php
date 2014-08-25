<?php

namespace Dolmen\Bundle\DolmenBundle\DependencyInjection\Factory;

use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Create brand new instances of a dependency injection yaml file loader.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class YamlFileLoaderFactory
{
    /**
     * @param ContainerBuilder     $builder
     * @param FileLocatorInterface $locator
     *
     * @return YamlFileLoader
     */
    public function create(ContainerBuilder $builder, FileLocatorInterface $locator)
    {
        return new YamlFileLoader($builder, $locator);
    }
}
