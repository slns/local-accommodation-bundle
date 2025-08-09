# LocalDemoBundle

## Instalação

1. Adicione o bundle ao seu projeto Symfony (via Composer):

   ```bash
   composer require slns/local-demo-bundle:dev-main
   ```

2. Certifique-se de que o bundle está registrado em `config/bundles.php`:

   ```php
   LocalDemoBundle\\LocalDemoBundle::class => ['all' => true],
   ```

3. Pronto! Os serviços e funcionalidades do bundle ficam disponíveis automaticamente no seu projeto principal.

## Desinstalação

1. Remova o bundle com o Composer:

   ```bash
   composer remove slns/local-demo-bundle
   ```

2. (Opcional) Remova qualquer configuração personalizada relacionada ao bundle, se existir.

3. O bundle e seus serviços deixarão de estar disponíveis no projeto principal.
