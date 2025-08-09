<?php


namespace LocalAccommodationBundle\Controller;

use Symfony\Component\Yaml\Yaml;
use LocalAccommodationBundle\Entity\Maintenance;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaintenanceController extends AbstractController
{
    private function getSidebarMenu(): array
    {
        $menuFile = __DIR__ . '/../../menu.yaml';
        if (!file_exists($menuFile)) {
            return [];
        }
        $menuConfig = Yaml::parseFile($menuFile);
        return $menuConfig['sidebar'] ?? [];
    }
    #[Route('/local-accommodation/maintenance', name: 'local_accommodation_maintenance')]
    public function index(ManagerRegistry $registry): Response
    {
        $maintenance = $registry->getManager()->getRepository(Maintenance::class)->findAll();
        return $this->render('@LocalAccommodation/maintenance/index.html.twig', [
            'maintenance' => $maintenance,
            'sidebarMenu' => $this->getSidebarMenu(),
        ]);
    }
}
