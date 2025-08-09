<?php

namespace LocalAccommodationBundle\Menu;

class SidebarMenuProvider
{
    public function getMenuItems(): array
    {
        return [
            [
                'label' => 'Accommodation Bundle',
                'route' => 'local_accommodation_dashboard',
                'icon'  => 'fa fa-plug',
            ],
        ];
    }
}
