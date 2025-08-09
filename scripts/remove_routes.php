<?php

// Script para remover automaticamente as rotas do bundle do projeto principal
$routesFile = __DIR__ . '/../../../../config/routes.yaml';

if (!file_exists($routesFile)) {
    echo "[local-accommodation-bundle] Arquivo routes.yaml não encontrado no projeto principal.\n";
    exit(0);
}

$routesContent = file_get_contents($routesFile);

// Remover a seção do LocalAccommodationBundle
$pattern = '/\n# Importar rotas do LocalAccommodationBundle\nlocal_accommodation_bundle:\s*\n\s*resource:\s*[\'"]@LocalAccommodationBundle\/config\/routes\.yaml[\'"]?\n?/';
$newContent = preg_replace($pattern, '', $routesContent);

if ($newContent !== $routesContent) {
    if (file_put_contents($routesFile, $newContent)) {
        echo "[local-accommodation-bundle] Rotas do LocalAccommodationBundle removidas com sucesso!\n";
    } else {
        echo "[local-accommodation-bundle] Erro ao remover rotas do LocalAccommodationBundle.\n";
        exit(1);
    }
} else {
    echo "[local-accommodation-bundle] Nenhuma configuração de rotas do LocalAccommodationBundle encontrada para remover.\n";
}
