<?php

namespace Dolmen\Bundle\DolmenBundle\DependencyInjection\Factory;

use Dolmen\Bundle\DolmenBundle\DependencyInjection\Configuration;

/**
 * Create brand new instances of dolmen dependency injection configuration.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class ConfigurationFactory
{
    /**
     * @return Configuration
     */
    public function create()
    {
        return new Configuration;
    }
}
