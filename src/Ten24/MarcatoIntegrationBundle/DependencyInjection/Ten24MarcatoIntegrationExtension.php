<?php

namespace Ten24\MarcatoIntegrationBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Yaml\Yaml;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class Ten24MarcatoIntegrationExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs,
                         ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        // Add container parameters from processed configuration
        $container->setParameter('ten24_marcato_integration.enabled', $config['enabled']);
        $container->setParameter('ten24_marcato_integration.organization_id', $config['organization_id']);
        $container->setParameter('ten24_marcato_integration.feeds.configuration', $config['feeds_config']);
        $container->setParameter('ten24_marcato_integration.feeds.artists.enabled', $config['feeds_config']['artists']);
        $container->setParameter('ten24_marcato_integration.feeds.contacts.enabled', $config['feeds_config']['contacts']);
        $container->setParameter('ten24_marcato_integration.feeds.shows.enabled', $config['feeds_config']['shows']);
        $container->setParameter('ten24_marcato_integration.feeds.venues.enabled', $config['feeds_config']['venues']);
        $container->setParameter('ten24_marcato_integration.feeds.workshops.enabled', $config['feeds_config']['workshops']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container)
    {
        $liipConfig = Yaml::parse(file_get_contents(__DIR__ . '/../Resources/config/liip_imagine.yml'));
        $container->prependExtensionConfig('liip_imagine', $liipConfig['liip_imagine']);

        $configs = $container->getExtensionConfig($this->getAlias());
        $this->processConfiguration(new Configuration(), $configs);
    }

    public function getAlias()
    {
        return 'ten24_marcato_integration';
    }
}
