<?php return [
    'namespace' => 'EnvInterop\\Interface\\',
    'directory' => dirname(__DIR__) . '/src',
    'template' => dirname(__DIR__) . '/resources/README.tpl.md',
    'interfaces' => [
        'EnvLoaderService',
        'EnvParserService',
        'EnvSetterService',
        'EnvGetter',
        'EnvThrowable',
        'EnvLoaderThrowable',
        'EnvParserThrowable',
        'EnvInvalidThrowable',
        'EnvTypeAliases',
    ],
];
