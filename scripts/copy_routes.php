<?php

// Script para adicionar automaticamente as rotas do bundle ao projeto principal
$routesFile = __DIR__ . '/../../../../config/routes.yaml';

if (!file_exists($routesFile)) {
    echo "[local-accommodation-bundle] Arquivo routes.yaml não encontrado no projeto principal.\n";
    exit(1);
}

$routesContent = file_get_contents($routesFile);

// Verificar se a importação já existe
if (strpos($routesContent, '@LocalAccommodationBundle/config/routes.yaml') !== false) {
    echo "[local-accommodation-bundle] Rotas do LocalAccommodationBundle já estão configuradas.\n";
    exit(0);
}

// Adicionar a importação das rotas
$routesToAdd = "\n# Importar rotas do LocalAccommodationBundle\nlocal_accommodation_bundle:\n    resource: '@LocalAccommodationBundle/config/routes.yaml'\n";
$routesContent .= $routesToAdd;

if (file_put_contents($routesFile, $routesContent)) {
    echo "[local-accommodation-bundle] Rotas do LocalAccommodationBundle adicionadas com sucesso!\n";
} else {
    echo "[local-accommodation-bundle] Erro ao adicionar rotas do LocalAccommodationBundle.\n";
    exit(1);
}
