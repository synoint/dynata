<?php

namespace Syno\Dynata\Bundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;
use Syno\Dynata\Demand;
use Syno\Dynata\HttpClient;

class SynoDynataExtension extends ConfigurableExtension
{
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../../../config'));
        $loader->load('services.yaml');

        $demand = $mergedConfig['demand'] ?? [];
        if (!empty($demand['api_domain']) && !empty($demand['api_key'])) {
            $demandConfigDef = $container->getDefinition(Demand\Client::class);
            $demandConfigDef->setArguments([$container->getDefinition(HttpClient::class), $demand['api_domain'], $demand['api_key']]);
        } else {
            $demandResources = $container->findTaggedServiceIds('syno.dynata.demand_resource');
            foreach (array_keys($demandResources) as $demandResourceId) {
                $container->removeDefinition($demandResourceId);
            }
        }

    }
}
