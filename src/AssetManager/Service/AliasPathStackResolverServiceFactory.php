<?php

namespace AssetManager\Service;

use AssetManager\Resolver\AliasPathStackResolver;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use AssetManager\Resolver\PathStackResolver;

class AliasPathStackResolverServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return PathStackResolver
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config  = $serviceLocator->get('config');
        $aliases = array();

        if (isset($config['asset_manager']['resolver_configs']['aliases'])) {
            $aliases = $config['asset_manager']['resolver_configs']['aliases'];
        }

        return new AliasPathStackResolver($aliases);
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return $this->createService($container);
    }
}
