<?php

namespace LocalAccommodationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Yaml;


class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'local_accommodation_dashboard')]
    public function index(): Response
    {
        $menuFile = __DIR__ . '/../../menu.yaml';
        $menuConfig = Yaml::parseFile($menuFile);
        $sidebarMenu = $menuConfig['sidebar'] ?? [];

        return $this->render('@LocalAccommodation/dashboard.html.twig', [
            'dummyData' => [
                'total' => 42,
                'message' => 'Bem-vindo ao Accommodation do Bundle!',
            ],
            'sidebarMenu' => $sidebarMenu,
        ]);
    }
}
