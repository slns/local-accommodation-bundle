use Symfony\Component\HttpFoundation\Request;
#[Route('/local-accommodation/consumables/new', name: 'local_accommodation_consumables_new')]
public function new(Request $request, ManagerRegistry $registry): Response
{
$entityManager = $registry->getManager();
$consumable = new Consumable();
$error = null;

if ($request->isMethod('POST')) {
$consumable->setName($request->request->get('name'));
$consumable->setStock((int)$request->request->get('stock'));
$entityManager->persist($consumable);
$entityManager->flush();
return $this->redirectToRoute('local_accommodation_consumables');
}

return $this->render('@LocalAccommodation/consumables/new.html.twig', [
'consumable' => $consumable,
'sidebarMenu' => $this->getSidebarMenu(),
'error' => $error,
]);
}
<?php


namespace LocalAccommodationBundle\Controller;

use Symfony\Component\Yaml\Yaml;
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
