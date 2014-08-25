<?php

namespace spec\Dolmen\Bundle\DolmenBundle\DependencyInjection\Factory;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConfigurationFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Dolmen\Bundle\DolmenBundle\DependencyInjection\Factory\ConfigurationFactory');
    }

    function it_create_new_configuration_instances()
    {
        $this->create()->shouldHaveType('Dolmen\Bundle\DolmenBundle\DependencyInjection\Configuration');
    }
}
