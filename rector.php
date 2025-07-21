<?php

declare(strict_types=1);

use App\RectorCoversFunction;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/tests',
    ])
//    ->withSets([
//       \Rector\PHPUnit\Set\PHPUnitSetList::ANNOTATIONS_TO_ATTRIBUTES,
//    ]);
    ->withRules([
            RectorCoversFunction::class
    ]);
