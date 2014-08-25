<?php

namespace Dolmen\Bundle\DolmenBundle\Explorer;

/**
 * Explore a given directory and return all the command register inside as
 * a container definition.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class CommandExplorer
{
    private $directory;

    /**
     * @param string $directory, Path to a directory
     */
    public function __construct($directory)
    {
        $this->directory = $directory;
    }

    /**
     * @return Definition[]
     */
    public function explore()
    {
    }
}
