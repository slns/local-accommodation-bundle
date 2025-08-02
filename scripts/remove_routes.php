<?php
// scripts/remove_routes.php
$target = __DIR__ . '/../../../../config/routes/local_demo_bundle.yaml';
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