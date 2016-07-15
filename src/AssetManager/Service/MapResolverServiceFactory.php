<?php

namespace AssetManager\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use AssetManager\Resolver\MapResolver;

class MapResolverServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return MapResolver
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $map    = array();

        if (isset($config['asset_manager']['resolver_configs']['map'])) {
            $map = $config['asset_manager']['resolver_configs']['map'];
        }

        $patchStackResolver = new MapResolver($map);

        return $patchStackResolver;
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return $this->createService($container);
    }
}
