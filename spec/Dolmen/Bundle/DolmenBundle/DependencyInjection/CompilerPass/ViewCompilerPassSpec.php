<?php

namespace spec\Dolmen\Bundle\DolmenBundle\DependencyInjection\CompilerPass;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Dolmen\Bundle\DolmenBundle\DependencyInjection\Factory\ReferenceFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;

class ViewCompilerPassSpec extends ObjectBehavior
{
    function let(ReferenceFactory $referenceFactory)
    {
        $this->beConstructedWith($referenceFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Dolmen\Bundle\DolmenBundle\DependencyInjection\CompilerPass\ViewCompilerPass');
    }

    function it_is_a_compiler_pass()
    {
        $this->shouldHaveType('Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface');
    }

    function it_register_view_services_inside_the_view_registry(
        ContainerBuilder $container,
        Reference $reference1,
        Reference $reference2,
        Definition $definition,
        $referenceFactory
    ) {
        $container->hasDefinition('dolmen.registry.view_registry')->shouldBeCalled()->willReturn(true);
        $container->getDefinition('dolmen.registry.view_registry')->shouldBeCalled()->willReturn($definition);
        $container
            ->findTaggedServiceIds('dolmen.view')
            ->shouldBeCalled()
            ->willreturn([
                'some.service.id' => ['attributes'],
                'other.service.id' => ['attributes']
            ])
        ;

        $referenceFactory->create('some.service.id')->shouldBeCalled()->willReturn($reference1);
        $referenceFactory->create('other.service.id')->shouldBeCalled()->willReturn($reference2);

        $definition->addMethodCall('add', [
            $reference1
        ])->shouldBeCalled();

        $definition->addMethodCall('add', [
            $reference2
        ])->shouldBeCalled();

        $this->process($container);
    }
}
