<?php

namespace spec\Dolmen\Bundle\DolmenBundle\DependencyInjection\Factory;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class YamlFileLoaderFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Dolmen\Bundle\DolmenBundle\DependencyInjection\Factory\YamlFileLoaderFactory');
    }

    function it_create_brand_new_yaml_file_loader(ContainerBuilder $builder, FileLocatorInterface $locator)
    {
        $this->create($builder, $locator)->shouldHaveType('Symfony\Component\DependencyInjection\Loader\YamlFileLoader');
    }
}
