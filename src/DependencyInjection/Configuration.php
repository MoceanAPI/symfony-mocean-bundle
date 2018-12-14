<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 12/14/2018
 * Time: 10:28 AM
 */

namespace MoceanSymBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('mocean');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('defaults')->defaultValue('main')->end()
                ->arrayNode('accounts')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('api_key')->defaultValue('xxxxxxx')->end()
                            ->scalarNode('api_secret')->defaultValue('xxxxxx')->end()
                            ->scalarNode('from')->defaultValue('xxxxxx')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
