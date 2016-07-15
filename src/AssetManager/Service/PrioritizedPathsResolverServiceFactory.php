<?php

namespace AssetManager\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use AssetManager\Resolver\PrioritizedPathsResolver;

class PrioritizedPathsResolverServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return PrioritizedPathsResolver
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config                   = $serviceLocator->get('config');
        $prioritizedPathsResolver = new PrioritizedPathsResolver();
        $paths                    = isset($config['asset_manager']['resolver_configs']['prioritized_paths'])
            ? $config['asset_manager']['resolver_configs']['prioritized_paths']
            : array();
        $prioritizedPathsResolver->addPaths($paths);

        return $prioritizedPathsResolver;
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return $this->createService($container);
    }
}
