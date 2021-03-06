<?php

namespace Serotoninja\DevBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Serotoninja\DevBundle\DependencyInjection
 *
 * @author serotoninja <serotoninja@gmail.com>
 * @since 2018-04-13
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/configuration.html
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('serotoninja_dev');

        $rootNode
            ->children()
                ->arrayNode('make_readme')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('folder')
                            ->defaultValue('src/Acme/FooBundle')
                            ->info('Working directory for make:readme.')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('make_license')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('folder')
                            ->defaultValue('src/Acme/FooBundle')
                            ->info('Working directory for make:license.')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
