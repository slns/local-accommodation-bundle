
<?php

use Symfony\Component\Yaml\Yaml;

namespace LocalAccommodationBundle\Controller;

use LocalAccommodationBundle\Entity\Consumable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsumableController extends AbstractController
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
    #[Route('/local-accommodation/consumables', name: 'local_accommodation_consumables')]
    public function index(ManagerRegistry $registry): Response
    {
        $consumables = $registry->getManager()->getRepository(Consumable::class)->findAll();
        return $this->render('@LocalAccommodation/consumables/index.html.twig', [
            'consumables' => $consumables,
            'sidebarMenu' => $this->getSidebarMenu(),
        ]);
    }
}
