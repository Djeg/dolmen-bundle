<?php

namespace spec\Dolmen\Bundle\DolmenBundle\Config\Factory;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileLocatorFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Dolmen\Bundle\DolmenBundle\Config\Factory\FileLocatorFactory');
    }

    function it_create_instance_of_config_file_lcoator()
    {
        $this->create(__DIR__)->shouldHaveType('Symfony\Component\Config\FileLocator');
    }
}
