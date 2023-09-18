<?php

declare(strict_types=1);

namespace Application\Factory;

use Application\Authentication\CustomAuthentication;
use Application\TableGateway\UserGateway;
use Laminas\ApiTools\MvcAuth\Authentication\OAuth2Adapter;
use Laminas\ApiTools\MvcAuth\Factory\OAuth2ServerFactory;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

use function is_array;

class CustomAuthenticationFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $config = $container->get('config');
        $adapterConfig = $config['api-tools-mvc-auth']['authentication']['adapters']['auth'];

        if (! isset($adapterConfig['storage']) || ! is_array($adapterConfig['storage'])) {
            throw new ServiceNotCreatedException('Missing storage details for OAuth2 server');
        }

        /** @var AdapterInterface $adapter */
        $adapter = $container->get('default.adapter');

        return new CustomAuthentication(
            new UserGateway($adapter),
            OAuth2ServerFactory::factory($adapterConfig['storage'], $container),
            'auth',
        );
    }
}
