<?php


namespace LocalAccommodationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/local-accommodation/laundry/new', name: 'local_accommodation_laundry_new')]
    public function new(Request $request, ManagerRegistry $registry): Response
    {
        $entityManager = $registry->getManager();
        $laundry = new Laundry();
        $error = null;

        if ($request->isMethod('POST')) {
            $laundry->setItem($request->request->get('item'));
            $deliveredAt = $request->request->get('deliveredAt');
            $receivedAt = $request->request->get('receivedAt');
            if ($deliveredAt) {
                $laundry->setDeliveredAt(new \DateTime($deliveredAt));
            }
            if ($receivedAt) {
                $laundry->setReceivedAt(new \DateTime($receivedAt));
            }
            $entityManager->persist($laundry);
            $entityManager->flush();
            return $this->redirectToRoute('local_accommodation_laundry');
        }

        return $this->render('@LocalAccommodation/laundry/new.html.twig', [
            'laundry' => $laundry,
            'sidebarMenu' => $this->getSidebarMenu(),
            'error' => $error,
        ]);
    }
}
