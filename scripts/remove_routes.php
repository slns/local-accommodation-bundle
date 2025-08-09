<?php
// scripts/remove_routes.php
// Detecta o caminho do projeto principal a partir da pasta vendor
$vendorDir = dirname(dirname(dirname(dirname(__DIR__))));
$target = $vendorDir . '/config/routes/local_demo_bundle.yaml';
if (file_exists($target)) {
    if (unlink($target)) {
        echo "[local-demo-bundle] Rotas removidas de $target\n";
    } else {
        echo "[local-demo-bundle] Falha ao remover rotas!\n";
        exit(1);
    }
} else {
    echo "[local-demo-bundle] Nenhum arquivo de rotas para remover.\n";
}
