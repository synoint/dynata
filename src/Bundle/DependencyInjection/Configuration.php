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
                    ->arrayNode('demand')
                        ->children()
                            ->variableNode('api_url')->end()
                        ->end()
                    ->end()
                    ->arrayNode('auth')
                        ->children()
                            ->variableNode('client_id')->end()
                        ->variableNode('api_url')->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
