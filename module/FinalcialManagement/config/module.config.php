<?php
return [
    'service_manager' => [
        'factories' => [
            \FinalcialManagement\V1\Rest\Transactions\TransactionsResource::class => \FinalcialManagement\V1\Rest\Transactions\TransactionsResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'finalcial-management.rest.transactions' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/transactions[/:transactions_id]',
                    'defaults' => [
                        'controller' => 'FinalcialManagement\\V1\\Rest\\Transactions\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'finalcial-management.rest.transactions',
        ],
    ],
    'api-tools-rest' => [
        'FinalcialManagement\\V1\\Rest\\Transactions\\Controller' => [
            'listener' => \FinalcialManagement\V1\Rest\Transactions\TransactionsResource::class,
            'route_name' => 'finalcial-management.rest.transactions',
            'route_identifier_name' => 'transactions_id',
            'collection_name' => 'transactions',
            'entity_http_methods' => [
                0 => 'GET',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'dateFrom',
                1 => 'dateTo',
            ],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \FinalcialManagement\V1\Rest\Transactions\TransactionsEntity::class,
            'collection_class' => \FinalcialManagement\V1\Rest\Transactions\TransactionsCollection::class,
            'service_name' => 'Transactions',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            'FinalcialManagement\\V1\\Rest\\Transactions\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'FinalcialManagement\\V1\\Rest\\Transactions\\Controller' => [
                0 => 'application/json',
                1 => 'application/hal+json',
                2 => 'application/vnd.finalcial-management.v1+json',
            ],
        ],
        'content_type_whitelist' => [
            'FinalcialManagement\\V1\\Rest\\Transactions\\Controller' => [
                0 => 'application/json',
                1 => 'application/vnd.finalcial-management.v1+json',
            ],
        ],
    ],
    'api-tools-hal' => [
        'metadata_map' => [
            \FinalcialManagement\V1\Rest\Transactions\TransactionsEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'finalcial-management.rest.transactions',
                'route_identifier_name' => 'transactions_id',
                'hydrator' => \Laminas\Hydrator\ReflectionHydrator::class,
            ],
            \FinalcialManagement\V1\Rest\Transactions\TransactionsCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'finalcial-management.rest.transactions',
                'route_identifier_name' => 'transactions_id',
                'is_collection' => true,
            ],
        ],
    ],
    'api-tools-mvc-auth' => [
        'authorization' => [
            'FinalcialManagement\\V1\\Rest\\Transactions\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
            ],
        ],
    ],
    'api-tools-content-validation' => [
        'FinalcialManagement\\V1\\Rest\\Transactions\\Controller' => [
            'input_filter' => 'FinalcialManagement\\V1\\Rest\\Transactions\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'FinalcialManagement\\V1\\Rest\\Transactions\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Laminas\I18n\Validator\IsFloat::class,
                        'options' => [],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\ToFloat::class,
                        'options' => [],
                    ],
                ],
                'name' => 'amount',
                'field_type' => 'float',
            ],
        ],
    ],
];
