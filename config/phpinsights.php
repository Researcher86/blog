<?php

declare(strict_types=1);

return [
    'preset' => 'default',
    'exclude' => [
        'config',
        'storage',
        'db',
        'vendor',
        'src/Infrastructure/Persistence/Doctrine/Migration',
        'src/Infrastructure/UI/Web/Template',
    ],
    'add' => [
        //  ExampleMetric::class => [
        //      ExampleInsight::class,
        //  ]
    ],
    'remove' => [
        //  ExampleInsight::class,
    ],
    'config' => [
        //  ExampleInsight::class => [
        //      'key' => 'value',
        //  ],
    ],
];