<?php

namespace LocalAccommodationBundle\Menu;

class SidebarMenuProvider
{
    public function getMenuItems(): array
    {
        return [
            [
                'label' => 'local_accommodation.dashboard.title',
                'route' => 'local_accommodation_dashboard',
                'icon'  => 'fa fa-plug',
            ],
        ];
    }
}
