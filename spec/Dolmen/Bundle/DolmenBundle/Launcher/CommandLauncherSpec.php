<?php

namespace spec\Dolmen\Bundle\DolmenBundle\Launcher;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Dolmen\Command\Launcher\Launchable;
use Dolmen\Context\Contextable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

class CommandLauncherSpec extends ObjectBehavior
{
    function let(Launchable $launcher, Contextable $context)
    {
        $this->beConstructedWith($launcher, $context);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Dolmen\Bundle\DolmenBundle\Launcher\CommandLauncher');
    }

    function it_launch_all_the_commands_stored_in_a_request(
        Request      $request,
        ParameterBag $attributes,
        $launcher,
        $context
    ) {
        $context->set('request', $request)->shouldBeCalled();

        $request->attributes = $attributes;

        $attributes->get('_commands')->shouldBeCalled()->willReturn(['some', 'commands']);

        $launcher->launch('some', $context)->shouldBeCalled()->willReturn(null);
        $launcher->launch('commands', $context)->shouldBeCalled()->willReturn(null);

        $this->launch($request)->shouldReturn($context);
    }
}
