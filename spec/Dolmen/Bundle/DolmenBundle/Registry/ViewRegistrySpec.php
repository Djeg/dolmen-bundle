<?php

namespace spec\Dolmen\Bundle\DolmenBundle\Registry;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Dolmen\View\ViewableContext;

class ViewRegistrySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Dolmen\Bundle\DolmenBundle\Registry\ViewRegistry');
    }

    function it_stores_and_retrieves_views(
        ViewableContext $view1,
        ViewableContext $view2
    ) {
        $view1->getName()->shouldBeCalled()->willReturn('first view');
        $view2->getName()->shouldBeCalled()->willReturn('second view');

        $this->add($view1);
        $this->add($view2);

        $this->has('first view')->shouldReturn(true);
        $this->has('second view')->shouldReturn(true);
        $this->has('undefined view')->shouldReturn(false);

        $this->get('first view')->shouldReturn($view1);
        $this->get('second view')->shouldReturn($view2);
        $this->shouldThrow('InvalidArgumentException')->duringGet('undefined view');
    }
}
