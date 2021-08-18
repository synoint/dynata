<?php

namespace Syno\Dynata\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('syno_dynata');

        $treeBuilder->getRootNode()
            ->children()
            // Demand
            ->arrayNode('demand')
            ->children()
            ->variableNode('api_domain')->end()
            ->variableNode('api_key')->end()
            ->variableNode('api_domain')->end()
            ->end()
            ->end()
            // End Demand
            ->end()
        ;

        return $treeBuilder;
    }
}
