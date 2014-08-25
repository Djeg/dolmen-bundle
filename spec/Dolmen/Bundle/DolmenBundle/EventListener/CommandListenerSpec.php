<?php

namespace spec\Dolmen\Bundle\DolmenBundle\EventListener;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

class CommandListenerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Dolmen\Bundle\DolmenBundle\EventListener\CommandListener');
    }

    function it_defined_the_default_controller_for_all_dolmen_tagged_requests(
        GetResponseEvent $event,
        Request          $request,
        ParameterBag     $attributes
    ) {
        $event->getRequest()->shouldBeCalled()->willReturn($request);

        $request->attributes = $attributes;

        $attributes->has('_dolmen')->shouldBeCalled()->willReturn(true);
        $attributes->set('_controller', 'dolmen.launcher.command_launcher:launch')->shouldBeCalled();

        $this->onKernelRequest($event);
    }

    function it_only_support_dolmen_tagged_requests(
        GetResponseEvent $event,
        Request          $request,
        ParameterBag     $attributes
    ) {
        $event->getRequest()->shouldBeCalled()->willReturn($request);

        $request->attributes = $attributes;

        $attributes->has('_dolmen')->shouldBeCalled()->willReturn(false);
        $attributes->set('_controller', Argument::any())->shouldNotBeCalled();

        $this->onKernelRequest($event);
    }
}
