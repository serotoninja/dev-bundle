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
                    ->children()
                        ->scalarNode('input_yaml')
                            ->info('The location of the yaml input file.')
                        ->end()
                        ->scalarNode('target_dir')
                            ->info('The target directory.')
                        ->end()
                        ->booleanNode('overwrite')
                            ->defaultFalse()
                            ->info('Overwrite the target file if exists, default false.')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
