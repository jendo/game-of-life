<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\AppKernel;

if (getenv('TZ') === false) {
    error_log('TZ is not set');
    exit(1);
}

AppKernel::initGlobalState((string) getenv('TZ'), true);
