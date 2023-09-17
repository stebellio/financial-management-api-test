<?php

declare(strict_types=1);

namespace FinalcialManagement;

use Laminas\ApiTools\Autoloader;
use Laminas\ApiTools\Provider\ApiToolsProviderInterface;

class Module implements ApiToolsProviderInterface
{
    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array[]
     */
    public function getAutoloaderConfig()
    {
        return [
            Autoloader::class => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src',
                ],
            ],
        ];
    }
}
