<?php

declare(strict_types=1);

use FinalcialManagement\V1\Rest\Test\TestCollection;
use FinalcialManagement\V1\Rest\Test\TestEntity;
use FinalcialManagement\V1\Rest\Test\TestResource;
use FinalcialManagement\V1\Rest\Test\TestResourceFactory;
use FinalcialManagement\V1\Rest\Transactions\TransactionsCollection;
use FinalcialManagement\V1\Rest\Transactions\TransactionsEntity;
use FinalcialManagement\V1\Rest\Transactions\TransactionsResource;
use FinalcialManagement\V1\Rest\Transactions\TransactionsResourceFactory;
use Laminas\Hydrator\ArraySerializableHydrator;
use Laminas\Hydrator\ReflectionHydrator;

return [
    'service_manager'               => [
        'factories' => [
            TransactionsResource::class => TransactionsResourceFactory::class,
            TestResource::class         => TestResourceFactory::class,
        ],
    ],
    'router'                        => [
        'routes' => [
            'finalcial-management.rest.transactions' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/transactions[/:transactions_id]',
                    'defaults' => [
                        'controller' => 'FinalcialManagement\\V1\\Rest\\Transactions\\Controller',
                    ],
                ],
            ],
            'finalcial-management.rest.test'         => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/test[/:test_id]',
                    'defaults' => [
                        'controller' => 'FinalcialManagement\\V1\\Rest\\Test\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning'          => [
        'uri' => [
            0 => 'finalcial-management.rest.transactions',
            1 => 'finalcial-management.rest.test',
        ],
    ],
    'api-tools-rest'                => [
        'FinalcialManagement\\V1\\Rest\\Transactions\\Controller' => [
            'listener'                   => TransactionsResource::class,
            'route_name'                 => 'finalcial-management.rest.transactions',
            'route_identifier_name'      => 'transactions_id',
            'collection_name'            => 'transactions',
            'entity_http_methods'        => [
                0 => 'GET',
            ],
            'collection_http_methods'    => [
                0 => 'GET',
            ],
            'collection_query_whitelist' => [
                0 => 'dateFrom',
                1 => 'dateTo',
            ],
            'page_size'                  => 25,
            'page_size_param'            => null,
            'entity_class'               => TransactionsEntity::class,
            'collection_class'           => TransactionsCollection::class,
            'service_name'               => 'Transactions',
        ],
        'FinalcialManagement\\V1\\Rest\\Test\\Controller'         => [
            'listener'                   => TestResource::class,
            'route_name'                 => 'finalcial-management.rest.test',
            'route_identifier_name'      => 'test_id',
            'collection_name'            => 'test',
            'entity_http_methods'        => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods'    => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size'                  => 25,
            'page_size_param'            => null,
            'entity_class'               => TestEntity::class,
            'collection_class'           => TestCollection::class,
            'service_name'               => 'test',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers'            => [
            'FinalcialManagement\\V1\\Rest\\Transactions\\Controller' => 'HalJson',
            'FinalcialManagement\\V1\\Rest\\Test\\Controller'         => 'HalJson',
        ],
        'accept_whitelist'       => [
            'FinalcialManagement\\V1\\Rest\\Transactions\\Controller' => [
                0 => 'application/json',
                1 => 'application/hal+json',
                2 => 'application/vnd.finalcial-management.v1+json',
            ],
            'FinalcialManagement\\V1\\Rest\\Test\\Controller'         => [
                0 => 'application/vnd.finalcial-management.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'FinalcialManagement\\V1\\Rest\\Transactions\\Controller' => [
                0 => 'application/json',
                1 => 'application/vnd.finalcial-management.v1+json',
            ],
            'FinalcialManagement\\V1\\Rest\\Test\\Controller'         => [
                0 => 'application/vnd.finalcial-management.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'api-tools-hal'                 => [
        'metadata_map' => [
            TransactionsEntity::class     => [
                'entity_identifier_name' => 'id',
                'route_name'             => 'finalcial-management.rest.transactions',
                'route_identifier_name'  => 'transactions_id',
                'hydrator'               => ReflectionHydrator::class,
            ],
            TransactionsCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name'             => 'finalcial-management.rest.transactions',
                'route_identifier_name'  => 'transactions_id',
                'is_collection'          => true,
            ],
            TestEntity::class             => [
                'entity_identifier_name' => 'id',
                'route_name'             => 'finalcial-management.rest.test',
                'route_identifier_name'  => 'test_id',
                'hydrator'               => ArraySerializableHydrator::class,
            ],
            TestCollection::class         => [
                'entity_identifier_name' => 'id',
                'route_name'             => 'finalcial-management.rest.test',
                'route_identifier_name'  => 'test_id',
                'is_collection'          => true,
            ],
        ],
    ],
    'api-tools-mvc-auth'            => [
        'authorization' => [
            'FinalcialManagement\\V1\\Rest\\Transactions\\Controller' => [
                'collection' => [
                    'GET'    => true,
                    'POST'   => false,
                    'PUT'    => false,
                    'PATCH'  => false,
                    'DELETE' => false,
                ],
                'entity'     => [
                    'GET'    => true,
                    'POST'   => false,
                    'PUT'    => false,
                    'PATCH'  => false,
                    'DELETE' => false,
                ],
            ],
        ],
    ],
    'api-tools-content-validation'  => [
        'FinalcialManagement\\V1\\Rest\\Transactions\\Controller' => [
            'input_filter' => 'FinalcialManagement\\V1\\Rest\\Transactions\\Validator',
        ],
    ],
    'input_filter_specs'            => [
        'FinalcialManagement\\V1\\Rest\\Transactions\\Validator' => [],
    ],
];
