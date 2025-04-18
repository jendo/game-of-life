<?php

declare(strict_types=1);

namespace App;

use App\DependencyInjection\CompilerPass\CommandsToApplicationCompilerPass;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\ErrorHandler\ErrorHandler;
use Symfony\Component\HttpKernel\Kernel;

final class AppKernel extends Kernel
{
    public function registerBundles(): iterable
    {
        return [];
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__ . '/../config/services.yml');
    }

    public static function initGlobalState(string $timezoneId, bool $debug): void
    {
        mb_internal_encoding('UTF-8');
        date_default_timezone_set($timezoneId);

        ErrorHandler::register(new ErrorHandler(null, $debug));
    }

    protected function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new CommandsToApplicationCompilerPass());
    }
}
