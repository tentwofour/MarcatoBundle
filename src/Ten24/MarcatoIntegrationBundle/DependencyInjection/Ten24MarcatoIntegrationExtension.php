<?php

namespace Ten24\MarcatoIntegrationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class Ten24MarcatoIntegrationExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        // Pass the default cache provider to the Configuration here.
        $configuration = new Configuration(
            //$container->get('ten24_marcato_integration.cache.adapter.array')
        );

        $config = $this->processConfiguration($configuration, $configs);

        // Add container parameters from processed configuration
        $container->setParameter('ten24_marcato_integration.enabled', $config['enabled']);
        $container->setParameter('ten24_marcato_integration.organization_id', $config['organization_id']);
        $container->setParameter('ten24_marcato_integration.feeds.configuration', $config['feeds_config']);
        $container->setParameter('ten24_marcato_integration.feeds.artists.enabled', $config['feeds_config']['artists']);
        $container->setParameter('ten24_marcato_integration.feeds.contacts.enabled', $config['feeds_config']['contacts']);
        $container->setParameter('ten24_marcato_integration.feeds.shows.enabled', $config['feeds_config']['shows']);
        $container->setParameter('ten24_marcato_integration.feeds.venues.enabled', $config['feeds_config']['venues']);
        $container->setParameter('ten24_marcato_integration.feeds.workshops.enabled', $config['feeds_config']['workshops']);
        //$container->setParameter('ten24_marcato_integration.cache.provider', $config['cache']['provider']);
        $container->setParameter('ten24_marcato_integration.cache.lifetime', $config['cache']['lifetime']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

    }

    public function getAlias()
    {
        return 'ten24_marcato_integration';
    }
}
