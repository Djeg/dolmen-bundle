<?php

namespace Dolmen\Bundle\DolmenBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Dolmen\Bundle\DolmenBundle\DependencyInjection\Factory\ConfigurationFactory;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Dolmen\Bundle\DolmenBundle\Config\Factory\FileLocatorFactory;
use Dolmen\Bundle\DolmenBundle\DependencyInjection\Factory\YamlFileLoaderFactory;

/**
 * Dependency injection extension. Load and configure dolmen DIC.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class DolmenExtension extends Extension
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var FileLocatorFactory
     */
    private $locatorFactory;

    /**
     * @var YamlFileLoaderFactory
     */
    private $loaderFactory;

    /**
     * @param ConfigurationFactory  $configFactory
     * @param FileLocatorFactory    $locatorFactory
     * @param YamlFileLoaderFactory $loaderFactory
     */
    public function __construct(
        ConfigurationFactory  $configFactory  = null,
        FileLocatorFactory    $locatorFactory = null,
        YamlFileLoaderFactory $loaderFactory  = null
    ) {
        $this->configuration  = $configFactory ? $configFactory->create() : null;
        $this->locatorFactory = $locatorFactory ?: new FileLocatorFactory;
        $this->loaderFactory  = $loaderFactory ?: new YamlFileLoaderFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config        = $this->processConfiguration($configuration, $configs);
        $locator       = $this->locatorFactory->create(__DIR__.'/../Resources/config');
        $loader        = $this->loaderFactory->create($container, $locator);

        $loader->load('dolmen.yml');
        $loader->load('registry.yml');
        $loader->load('event.yml');
        $loader->load('launcher.yml');
        $loader->load('view.yml');
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        if (null === $this->configuration) {
            $this->configuration = new Configuration;
        }

        return $this->configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'dolmen';
    }
}
