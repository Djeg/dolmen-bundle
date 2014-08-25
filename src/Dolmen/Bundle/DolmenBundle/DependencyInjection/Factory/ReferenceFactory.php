<?php

namespace Dolmen\Bundle\DolmenBundle\DependencyInjection\Factory;

use Symfony\Component\DependencyInjection\Reference;

/**
 * Create a new dependency injection reference instance.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class ReferenceFactory
{
    /**
     * @param mixed $id
     *
     * @return Reference
     */
    public function create($id)
    {
        return new Reference($id);
    }
}
