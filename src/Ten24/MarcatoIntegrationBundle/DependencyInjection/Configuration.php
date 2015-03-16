<?php

namespace Ten24\MarcatoIntegrationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ten24_marcato_integration');

        $rootNode
            ->children()

                ->booleanNode('enabled')
                    ->treatNullLike(false)
                    ->defaultTrue()
                    ->info('Enable this bundle and its services, commands, and cache warmer')
                ->end()

                ->integerNode('organization_id')
                    ->defaultValue(8)
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->info('Your Marcato organization ID')
                    ->example('23456')
                ->end() // integerNode

                ->arrayNode('feeds_config')
                    ->addDefaultsIfNotSet()
                    ->info('Configure which feeds you have enabled in your Marcato Application. Without defining these fields, the bundle will assume that all feeds are enabled.')
                    ->children()
                        ->booleanNode('artists')
                            ->defaultTrue()
                            ->info('Artist feed enabled?')
                        ->end()

                        ->booleanNode('contacts')
                            ->defaultTrue()
                            ->info('Contacts feed enabled?')
                        ->end()

                        ->booleanNode('shows')
                            ->defaultTrue()
                            ->info('Shows feed enabled?')
                        ->end()

                        ->booleanNode('venues')
                            ->defaultTrue()
                            ->info('Venues feed enabled?')
                        ->end()

                        ->booleanNode('workshops')
                            ->defaultTrue()
                            ->info('Workshops feed enabled?')
                        ->end()

                    ->end() // children
                ->end() // arrayNode
            ->end(); // Children (of root)

        return $treeBuilder;
    }
}
