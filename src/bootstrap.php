<?php
use Nette\DI\Compiler;
use Nette\DI\ContainerLoader;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$baseDir = dirname(__DIR__);
require_once __DIR__ . '/vendor/autoload.php';

$loader = new ContainerLoader(__DIR__ . '/temp', $autoRebuild = true);
$class = $loader->load(
    function (Compiler $compiler) use ($baseDir) {
        $compiler->addConfig(['parameters' => ['baseDir' => __DIR__]]);
        $compiler->loadConfig(__DIR__ . '/config/config.neon');
    }
);
return new $class;
