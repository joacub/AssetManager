<?php

namespace AssetManager\Service;

use Interop\Container\ContainerInterface;
use Tracy\Debugger;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use AssetManager\Resolver\AggregateResolver;
use AssetManager\Exception;
use AssetManager\Resolver\AggregateResolverAwareInterface;
use AssetManager\Resolver\MimeResolverAwareInterface;
use AssetManager\Resolver\ResolverInterface;

/**
 * Factory class for AssetManagerService
 *
 * @category   AssetManager
 * @package    AssetManager
 */
class AggregateResolverServiceFactory implements FactoryInterface
{

    /**
     * {@inheritDoc}
     *
     * @return AggregateResolver
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config         = $serviceLocator->get('Config');
        $config         = isset($config['asset_manager']) ? $config['asset_manager'] : array();
        $resolver       = new AggregateResolver();

        if (empty($config['resolvers'])) {
            return $resolver;
        }

        foreach ($config['resolvers'] as $resolverService => $priority) {

            Debugger::barDump($resolverService);
            $resolverService = $serviceLocator->get($resolverService);
            Debugger::barDump($resolverService);

            if (!$resolverService instanceof ResolverInterface) {
                throw new Exception\RuntimeException(
                    'Service does not implement the required interface ResolverInterface.'
                );
            }

            if ($resolverService instanceof AggregateResolverAwareInterface) {
                $resolverService->setAggregateResolver($resolver);
            }

            if ($resolverService instanceof MimeResolverAwareInterface) {
                $resolverService->setMimeResolver($serviceLocator->get('AssetManager\Service\MimeResolver'));
            }

            if ($resolverService instanceof AssetFilterManagerAwareInterface) {
                $resolverService->setAssetFilterManager(
                    $serviceLocator->get('AssetManager\Service\AssetFilterManager')
                );
            }

            $resolver->attach($resolverService, $priority);
        }

        return $resolver;
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return $this->createService($container);
    }


}
