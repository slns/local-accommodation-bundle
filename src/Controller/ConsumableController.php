<?php

namespace LocalAccommodationBundle\Controller;

use LocalAccommodationBundle\Entity\Consumable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsumableController extends AbstractController
{
    #[Route('/local-accommodation/consumables', name: 'local_accommodation_consumables')]
    public function index(ManagerRegistry $registry): Response
    {
        $consumables = $registry->getManager()->getRepository(Consumable::class)->findAll();
        return $this->render('@LocalAccommodation/consumables/index.html.twig', [
            'consumables' => $consumables
        ]);
    }
}
