<?php

namespace spec\Dolmen\Bundle\DolmenBundle;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DolmenBundleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Dolmen\Bundle\DolmenBundle\DolmenBundle');
    }

    function it_should_be_a_bundle()
    {
        $this->shouldHaveType('Symfony\Component\HttpKernel\Bundle\Bundle');
    }

    function it_contains_a_container_extension()
    {
        $this->getContainerExtension()->shouldHaveType('Dolmen\Bundle\DolmenBundle\DependencyInjection\DolmenExtension');
    }
}
