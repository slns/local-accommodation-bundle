<?php

namespace LocalAccommodationBundle\Composer;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Installer\PackageEvents;
use Composer\Installer\PackageEvent;

class BundleInstaller implements PluginInterface, EventSubscriberInterface
{
    public function activate(Composer $composer, IOInterface $io): void {}

    public function deactivate(Composer $composer, IOInterface $io): void {}

    public function uninstall(Composer $composer, IOInterface $io): void {}

    public static function getSubscribedEvents(): array
    {
        return [
            PackageEvents::POST_PACKAGE_INSTALL => 'onPostPackageInstall',
            PackageEvents::PRE_PACKAGE_UNINSTALL => 'onPrePackageUninstall',
        ];
    }

    public static function onPostPackageInstall(PackageEvent $event): void
    {
        $op = $event->getOperation();
        $package = method_exists($op, 'getPackage') ? $op->getPackage() : (method_exists($op, 'getInitialPackage') ? $op->getInitialPackage() : null);
        if ($package && $package->getName() === 'slns/local-accommodation-bundle') {
            self::addRoutes();
        }
    }

    public static function onPrePackageUninstall(PackageEvent $event): void
    {
        $op = $event->getOperation();
        $package = method_exists($op, 'getPackage') ? $op->getPackage() : (method_exists($op, 'getInitialPackage') ? $op->getInitialPackage() : null);
        if ($package && $package->getName() === 'slns/local-accommodation-bundle') {
            self::removeRoutes();
        }
    }

    private static function addRoutes(): void
    {
        $routesFile = getcwd() . '/config/routes.yaml';

        if (!file_exists($routesFile)) {
            return;
        }

        $routesContent = file_get_contents($routesFile);

        if (strpos($routesContent, '@LocalAccommodationBundle/config/routes.yaml') !== false) {
            return;
        }

        $routesToAdd = "\n# Importar rotas do LocalAccommodationBundle\nlocal_accommodation_bundle:\n    resource: '@LocalAccommodationBundle/config/routes.yaml'\n";
        $routesContent .= $routesToAdd;

        file_put_contents($routesFile, $routesContent);
        echo "[local-accommodation-bundle] Rotas adicionadas automaticamente!\n";
    }

    private static function removeRoutes(): void
    {
        $routesFile = getcwd() . '/config/routes.yaml';

        if (!file_exists($routesFile)) {
            return;
        }

        $routesContent = file_get_contents($routesFile);
        $pattern = '/\n# Importar rotas do LocalAccommodationBundle\nlocal_accommodation_bundle:\s*\n\s*resource:\s*[\'"]@LocalAccommodationBundle\/config\/routes\.yaml[\'"]?\n?/';
        $newContent = preg_replace($pattern, '', $routesContent);

        if ($newContent !== $routesContent) {
            file_put_contents($routesFile, $newContent);
            echo "[local-accommodation-bundle] Rotas removidas automaticamente!\n";
        }
    }
}
