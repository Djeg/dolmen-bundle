<?php

namespace spec\Dolmen\Bundle\DolmenBundle\DependencyInjection\CompilerPass;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Dolmen\Bundle\DolmenBundle\DependencyInjection\Factory\ReferenceFactory;

class RegisterCommandsCompilerPassSpec extends ObjectBehavior
{
    function let(ReferenceFactory $referenceFactory)
    {
        $this->beConstructedWith($referenceFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Dolmen\Bundle\DolmenBundle\DependencyInjection\CompilerPass\RegisterCommandsCompilerPass');
    }

    function it_is_a_compiler_pass()
    {
        $this->shouldHaveType('Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface');
    }

    function it_supports_only_container_with_dolmen_launcher_service_definition(
        ContainerBuilder $container
    ) {
        $container->hasDefinition('dolmen.launcher')->shouldBeCalled()->willReturn(false);
        $container->getDefinition('dolmen.launcher')->shouldNotBeCalled();

        $this->process($container);
    }

    function it_register_command_definition_in_the_launcher_one(
        ContainerBuilder $container,
        Definition $definition,
        Reference $firstReference,
        Reference $secondReference,
        $referenceFactory
    ) {
        $container->hasDefinition('dolmen.launcher')->shouldBeCalled()->willReturn(true);
        $container->getDefinition('dolmen.launcher')->shouldBeCalled()->willReturn($definition);
        $container->findTaggedServiceIds('dolmen.command')->shouldBeCalled()->willReturn([
            'firstId' => ['arguments'],
            'secondId' => ['arguments']
        ]);

        $referenceFactory->create('firstId')->shouldBeCalled()->willReturn($firstReference);
        $referenceFactory->create('secondId')->shouldBeCalled()->willReturn($secondReference);

        $definition->addMethodCall('addCommand', [$firstReference])->shouldBeCalled();
        $definition->addMethodCall('addCommand', [$secondReference])->shouldBeCalled();

        $this->process($container);
    }
}
