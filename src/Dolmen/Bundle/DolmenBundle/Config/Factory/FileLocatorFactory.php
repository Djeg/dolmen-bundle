<?php

namespace Dolmen\Bundle\DolmenBundle\Config\Factory;

use Symfony\Component\Config\FileLocator;

/**
 * Create brand new instances of a config file locator.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class FileLocatorFactory 
{
    /**
     * @param string $directory
     *
     * @return FileLocator
     */
    public function create($directory)
    {
        return new FileLocator($directory);
    }
}
