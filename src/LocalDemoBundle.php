<?php

namespace LocalDemoBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class LocalDemoBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
