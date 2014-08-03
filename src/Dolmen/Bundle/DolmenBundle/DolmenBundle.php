<?php

namespace Dolmen\Bundle\DolmenBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Dolmen framework bundle.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class DolmenBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = ;
        }

        return $this->extension;
    }
}
