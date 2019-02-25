<?php
use Nette\DI\Container;

if (php_sapi_name() !== "cli") {
    die("Application must run from CLI");
}

/** @var Container $container */
$container = require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

/** @var GameOfLife\Application $application */
$application = $container->getService('application');
$application->run();

