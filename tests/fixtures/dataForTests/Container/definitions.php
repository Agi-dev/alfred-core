<?php
/**
 * This file is part of the alfred-core project
 *
 * (c) AgiDev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/** @noinspection PhpIncludeInspection */
include_once __DIR__ . '/../Service/Dummy/Dummy.php';
/** @noinspection PhpIncludeInspection */
include_once __DIR__ . '/../Service/DummyConfig/DummyConfig.php';
return [
    'configurations' => [
        'dummyConfig' => 'is configured',
    ],
    'services' => [
        'dummy'       => Dummy::class,
        'dummyConfig' => DummyConfig::class,
    ]
];
