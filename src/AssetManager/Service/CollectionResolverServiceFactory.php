<?php

namespace AssetManager\Service;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use AssetManager\Resolver\CollectionResolver;

class CollectionResolverServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return CollectionResolver
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config      = $serviceLocator->get('Config');
        $collections = array();

        if (isset($config['asset_manager']['resolver_configs']['collections'])) {
            $collections = $config['asset_manager']['resolver_configs']['collections'];
        }

        $collectionResolver = new CollectionResolver($collections);

        return $collectionResolver;
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return $this->createService($container);
    }


}
