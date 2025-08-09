<?php
// scripts/notify_services.php

$block = <<<YAML

# Adicione este bloco em config/services.yaml para ativar controllers do bundle:
LocalAccommodationBundle\Controller\:
    resource: "../vendor/slns/local-accommodation-bundle/src/Controller/"
    tags: ["controller.service_arguments"]
    autowire: true
    autoconfigure: true
    arguments:
        $sidebarMenuProvider: '@App\Menu\SidebarMenuProvider'
YAML;

$servicesPath = __DIR__ . '/../../../../config/services.yaml';

if (file_exists($servicesPath)) {
    echo "[local-accommodation-bundle] Atenção: Para ativar controllers do bundle, adicione o seguinte bloco ao final de $servicesPath:\n";
    echo $block . "\n";
} else {
    echo "[local-accommodation-bundle] Atenção: Crie o arquivo config/services.yaml e adicione:\n";
    echo $block . "\n";
}
