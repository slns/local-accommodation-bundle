<?php

namespace LocalAccommodationBundle\Controller;

use Symfony\Component\Yaml\Yaml;
use LocalAccommodationBundle\Entity\Consumable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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

    #[Route('/local-accommodation/consumables/new', name: 'local_accommodation_consumables_new')]
    public function new(Request $request, ManagerRegistry $registry): Response
    {
        $consumable = new Consumable();
        $form = $this->createForm(\LocalAccommodationBundle\Form\ConsumableType::class, $consumable);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $registry->getManager();
            $em->persist($consumable);
            $em->flush();
            return $this->redirectToRoute('local_accommodation_consumables');
        }
        return $this->render('@LocalAccommodation/consumables/new.html.twig', [
            'form' => $form->createView(),
            'sidebarMenu' => $this->getSidebarMenu(),
        ]);
    }

    #[Route('/local-accommodation/consumables/{id}/edit', name: 'local_accommodation_consumables_edit')]
    public function edit(int $id, Request $request, ManagerRegistry $registry): Response
    {
        $em = $registry->getManager();
        $consumable = $em->getRepository(Consumable::class)->find($id);
        if (!$consumable) {
            throw $this->createNotFoundException('Consumable not found');
        }
        $form = $this->createForm(\LocalAccommodationBundle\Form\ConsumableType::class, $consumable);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('local_accommodation_consumables');
        }
        return $this->render('@LocalAccommodation/consumables/edit.html.twig', [
            'form' => $form->createView(),
            'consumable' => $consumable,
            'sidebarMenu' => $this->getSidebarMenu(),
        ]);
    }

    #[Route('/local-accommodation/consumables/{id}/delete', name: 'local_accommodation_consumables_delete', methods: ['GET', 'POST'])]
    public function delete(int $id, Request $request, ManagerRegistry $registry): Response
    {
        $em = $registry->getManager();
        $consumable = $em->getRepository(Consumable::class)->find($id);
        if (!$consumable) {
            throw $this->createNotFoundException('Consumable not found');
        }
        if ($request->isMethod('POST')) {
            $em->remove($consumable);
            $em->flush();
            return $this->redirectToRoute('local_accommodation_consumables');
        }
        return $this->render('@LocalAccommodation/consumables/delete.html.twig', [
            'consumable' => $consumable,
            'sidebarMenu' => $this->getSidebarMenu(),
        ]);
    }
}
