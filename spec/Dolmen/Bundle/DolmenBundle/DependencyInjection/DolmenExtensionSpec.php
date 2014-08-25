<?php

namespace spec\Dolmen\Bundle\DolmenBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Dolmen\Bundle\DolmenBundle\DependencyInjection\Factory\ConfigurationFactory;
use Dolmen\Bundle\DolmenBundle\Config\Factory\FileLocatorFactory;
use Dolmen\Bundle\DolmenBundle\DependencyInjection\Configuration;
use Dolmen\Bundle\DolmenBundle\DependencyInjection\Factory\YamlFileLoaderFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\NodeInterface;

class DolmenExtensionSpec extends ObjectBehavior
{
    function let(
        ConfigurationFactory  $configFactory,
        FileLocatorFactory    $locatorFactory,
        YamlFileLoaderFactory $loaderFactory,
        Configuration         $config
    ) {
        $configFactory->create()->shouldBeCalled()->willReturn($config);

        $this->beConstructedWith($configFactory, $locatorFactory, $loaderFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Dolmen\Bundle\DolmenBundle\DependencyInjection\DolmenExtension');
    }

    function it_is_a_dolmen_extension()
    {
        $this->shouldHaveType('Symfony\Component\DependencyInjection\Extension\Extension');
    }

    function it_return_the_dolmen_bundle_alias()
    {
        $this->getAlias()->shouldReturn('dolmen');
    }

    function it_contains_the_dolmen_confiuration_instance(ContainerBuilder $container)
    {
        $this->getConfiguration(['some configuration'], $container)->shouldHaveType('Dolmen\Bundle\DolmenBundle\DependencyInjection\Configuration');
    }

    function it_load_dependency_injection_configuration_files(
        ContainerBuilder     $container,
        FileLocatorInterface $locator,
        YamlFileLoader       $loader,
        TreeBuilder          $treeBuilder,
        NodeInterface        $node,
        $locatorFactory,
        $loaderFactory,
        $config
    ) {
        $config->getConfigTreeBuilder()->willReturn($treeBuilder);
        $treeBuilder->buildTree()->willReturn($node);
        $locatorFactory->create(Argument::cetera())->shouldBeCalled()->willReturn($locator);
        $loaderFactory->create($container, $locator)->shouldBeCalled()->willReturn($loader);

        $loader->load('dolmen.yml')->shouldBeCalled()->willReturn(null);
        $loader->load('registry.yml')->shouldBeCalled()->willReturn(null);
        $loader->load('event.yml')->shouldBeCalled()->willReturn(null);
        $loader->load('launcher.yml')->shouldBeCalled()->willReturn(null);
        $loader->load('view.yml')->shouldBeCalled()->willReturn(null);

        $this->load(['some configuration'], $container);
    }
}
