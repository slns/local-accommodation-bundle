<?php

namespace LocalDemoBundle\Menu;

class SidebarMenuProvider
{
    public function getMenuItems(): array
    {
        return [
            [
                'label' => 'Demo Bundle',
                'route' => 'local_demo_dashboard',
                'icon'  => 'fa fa-plug',
            ],
        ];
    }
}
