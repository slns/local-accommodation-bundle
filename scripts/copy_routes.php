<?php
// scripts/copy_routes.php
$target = __DIR__ . '/../../../../config/routes/local_demo_bundle.yaml';
$source = __DIR__ . '/../config/routes/local_demo_bundle.yaml';

if (!file_exists($source)) {
    echo "[local-demo-bundle] Arquivo de rotas não encontrado: $source\n";
    exit(1);
}
if (!file_exists(dirname($target))) {
    mkdir(dirname($target), 0777, true);
}
if (copy($source, $target)) {
    echo "[local-demo-bundle] Rotas copiadas para $target\n";
} else {
    echo "[local-demo-bundle] Falha ao copiar rotas!\n";
    exit(1);
}