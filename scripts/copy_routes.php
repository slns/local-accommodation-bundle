<?php
// scripts/copy_routes.php
$target = __DIR__ . '/../../../../config/routes/local_demo_bundle.yaml';
$source = __DIR__ . '/../config/routes/local_demo_bundle.yaml';
// ...existing code...
$content = "local_demo_bundle:\n    resource: '../../vendor/slns/local-demo-bundle/config/routes.yaml'\n";

if (!is_dir(dirname($target))) {
    mkdir(dirname($target), 0777, true);
}

if (file_put_contents($target, $content) !== false) {
    echo "[local-demo-bundle] Rotas copiadas para $target\n";
} else {
    echo "[local-demo-bundle] Falha ao copiar rotas!\n";
    exit(1);
}
