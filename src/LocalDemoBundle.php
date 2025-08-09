
<?php

namespace LocalDemoBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use LocalDemoBundle\DependencyInjection\LocalDemoExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

class LocalDemoBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new LocalDemoExtension();
    }

    public function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import(__DIR__ . '/../config/routes.yaml');
    }
}
