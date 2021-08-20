<?php

namespace Syno\Dynata\Bundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;
use Syno\Dynata\Demand\Authentication;
use Syno\Dynata\Demand;

class SynoDynataExtension extends ConfigurableExtension
{
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../../../config'));
        $loader->load('services.yaml');

        $auth = $mergedConfig['auth'] ?? [];
        if (!empty($auth['client_id']) && !empty($auth['api_url'])) {
            $demandConfigDef = $container->getDefinition(Authentication\Client::class);
            $demandConfigDef->setArguments([$auth['api_url'], $auth['client_id']]);
        }

        $demand = $mergedConfig['demand'] ?? [];
        if (!empty($demand['api_url'])) {
            $demandConfigDef = $container->getDefinition(Demand\Client::class);
            $demandConfigDef->setArguments([$container->getDefinition(Authentication\Resources\Auth::class), $demand['api_url']]);
        }
    }
}
