<?php

// Script para remover automaticamente as rotas do bundle do projeto principal
$routesFile = __DIR__ . '/../../../../config/routes.yaml';

if (!file_exists($routesFile)) {
    echo "[local-demo-bundle] Arquivo routes.yaml não encontrado no projeto principal.\n";
    exit(0);
}

$routesContent = file_get_contents($routesFile);

// Remover a seção do LocalDemoBundle
$pattern = '/\n# Importar rotas do LocalDemoBundle\nlocal_demo_bundle:\s*\n\s*resource:\s*[\'"]@LocalDemoBundle\/config\/routes\.yaml[\'"]?\n?/';
$newContent = preg_replace($pattern, '', $routesContent);

if ($newContent !== $routesContent) {
    if (file_put_contents($routesFile, $newContent)) {
        echo "[local-demo-bundle] Rotas do LocalDemoBundle removidas com sucesso!\n";
    } else {
        echo "[local-demo-bundle] Erro ao remover rotas do LocalDemoBundle.\n";
        exit(1);
    }
} else {
    echo "[local-demo-bundle] Nenhuma configuração de rotas do LocalDemoBundle encontrada para remover.\n";
}
