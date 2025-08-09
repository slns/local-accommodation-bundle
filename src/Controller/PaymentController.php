
<?php

use Symfony\Component\Yaml\Yaml;

namespace LocalAccommodationBundle\Controller;

use LocalAccommodationBundle\Entity\Payment;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
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
    #[Route('/local-accommodation/payments', name: 'local_accommodation_payments')]
    public function index(ManagerRegistry $registry): Response
    {
        $payments = $registry->getManager()->getRepository(Payment::class)->findAll();
        return $this->render('@LocalAccommodation/payments/index.html.twig', [
            'payments' => $payments,
            'sidebarMenu' => $this->getSidebarMenu(),
        ]);
    }
}
