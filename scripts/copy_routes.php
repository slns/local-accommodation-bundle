<?php
// scripts/copy_routes.php

// Detecta o caminho do projeto principal a partir da pasta vendor
$vendorDir = dirname(dirname(dirname(dirname(__DIR__))));
$target = $vendorDir . '/config/routes/local_demo_bundle.yaml';
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
