<?php

namespace LocalDemoBundle\Controller;

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

    #[Route('/dashboard', name: 'local_demo_dashboard')]
    public function index(): Response
    {
        return $this->render('@LocalDemo/dashboard.html.twig', [
            'dummyData' => [
                'total' => 42,
                'message' => 'Bem-vindo ao Demo do Bundle!',
            ],
            'sidebarMenu' => $this->sidebarMenuProvider->getMenuItems(),
        ]);
    }
}
