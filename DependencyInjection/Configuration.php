<?php

namespace SymfonyContrib\Bundle\EmailTemplateBundle\DependencyInjection;

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
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('email_template');

        $rootNode->children()
            ->arrayNode('defaults')
                ->children()
                    ->scalarNode('from')->end()
                ->end()
            ->end()
            ->arrayNode('templates')
                ->defaultValue([])
                ->useAttributeAsKey('name')
                ->prototype('array')
                    ->children()
                        ->scalarNode('twig')->end()
                        ->arrayNode('tokens')
                            ->defaultValue([])
                            ->useAttributeAsKey('token')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
