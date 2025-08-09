<?php

namespace LocalAccommodationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Menu\SidebarMenuProvider;

class DashboardController extends AbstractController
{
    private SidebarMenuProvider $sidebarMenuProvider;

    public function __construct(SidebarMenuProvider $sidebarMenuProvider)
    {
        $this->sidebarMenuProvider = $sidebarMenuProvider;
    }

    #[Route('/dashboard', name: 'local_accommodation_dashboard')]
    public function index(): Response
    {
        return $this->render('@LocalAccommodation/dashboard.html.twig', [
            'dummyData' => [
                'total' => 42,
                'message' => 'Bem-vindo ao Accommodation do Bundle!',
            ],
            'sidebarMenu' => $this->sidebarMenuProvider->getMenuItems(),
        ]);
    }
}
