<?php

declare(strict_types=1);

use Laminas\Cache\Storage\Adapter\Filesystem;
use Laminas\Cache\Storage\Adapter\Memory;

return [
    'Laminas\\Mvc\\I18n',
    'Laminas\\I18n',
    'Laminas\\ComposerAutoloading',
    'Laminas\\Db',
    'Laminas\\Filter',
    'Laminas\\Hydrator',
    'Laminas\\InputFilter',
    'Laminas\\Paginator',
    'Laminas\\Router',
    'Laminas\\Validator',
    'Laminas\\ApiTools',
    'Laminas\\ApiTools\\Documentation',
    'Laminas\\ApiTools\\ApiProblem',
    'Laminas\\ApiTools\\Configuration',
    'Laminas\\ApiTools\\OAuth2',
    'Laminas\\ApiTools\\MvcAuth',
    'Laminas\\ApiTools\\Hal',
    'Laminas\\ApiTools\\ContentNegotiation',
    'Laminas\\ApiTools\\ContentValidation',
    'Laminas\\ApiTools\\Rest',
    'Laminas\\ApiTools\\Rpc',
    'Laminas\\ApiTools\\Versioning',
    'Laminas\\ZendFrameworkBridge',
    'DoctrineModule',
    Filesystem::class,
    Memory::class,
    'Application',
    'FinalcialManagement',
];
