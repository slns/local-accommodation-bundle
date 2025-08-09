<?php

// Script para adicionar automaticamente as rotas do bundle ao projeto principal
$routesFile = __DIR__ . '/../../../../config/routes.yaml';

if (!file_exists($routesFile)) {
    echo "[local-demo-bundle] Arquivo routes.yaml não encontrado no projeto principal.\n";
    exit(1);
}

$routesContent = file_get_contents($routesFile);

// Verificar se a importação já existe
if (strpos($routesContent, '@LocalDemoBundle/config/routes.yaml') !== false) {
    echo "[local-demo-bundle] Rotas do LocalDemoBundle já estão configuradas.\n";
    exit(0);
}

// Adicionar a importação das rotas
$routesToAdd = "\n# Importar rotas do LocalDemoBundle\nlocal_demo_bundle:\n    resource: '@LocalDemoBundle/config/routes.yaml'\n";
$routesContent .= $routesToAdd;

if (file_put_contents($routesFile, $routesContent)) {
    echo "[local-demo-bundle] Rotas do LocalDemoBundle adicionadas com sucesso!\n";
} else {
    echo "[local-demo-bundle] Erro ao adicionar rotas do LocalDemoBundle.\n";
    exit(1);
}
