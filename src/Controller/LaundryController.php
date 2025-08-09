<?php

use Symfony\Component\Yaml\Yaml;

namespace LocalAccommodationBundle\Controller;

use LocalAccommodationBundle\Entity\Laundry;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LaundryController extends AbstractController
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
    #[Route('/local-accommodation/laundry', name: 'local_accommodation_laundry')]
    public function index(ManagerRegistry $registry): Response
    {
        $laundry = $registry->getManager()->getRepository(Laundry::class)->findAll();
        return $this->render('@LocalAccommodation/laundry/index.html.twig', [
            'laundry' => $laundry,
            'sidebarMenu' => $this->getSidebarMenu(),
        ]);
    }
}
