<?php


namespace LocalAccommodationBundle\Controller;

use Symfony\Component\Yaml\Yaml;
use LocalAccommodationBundle\Entity\Guest;
use LocalAccommodationBundle\Form\GuestType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GuestController extends AbstractController
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

    #[Route('/local-accommodation/guests', name: 'local_accommodation_guests')]
    public function index(ManagerRegistry $registry): Response
    {
        $guests = $registry->getManager()->getRepository(Guest::class)->findAll();
        return $this->render('@LocalAccommodation/guests/index.html.twig', [
            'guests' => $guests,
            'sidebarMenu' => $this->getSidebarMenu(),
        ]);
    }

    #[Route('/local-accommodation/guests/new', name: 'local_accommodation_guests_new')]
    public function new(Request $request, ManagerRegistry $registry): Response
    {
        $guest = new Guest();
        $form = $this->createForm(GuestType::class, $guest);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $registry->getManager();
            $em->persist($guest);
            $em->flush();
            return $this->redirectToRoute('local_accommodation_guests');
        }
        return $this->render('@LocalAccommodation/guests/new.html.twig', [
            'form' => $form->createView(),
            'sidebarMenu' => $this->getSidebarMenu(),
        ]);
    }

    #[Route('/local-accommodation/guests/{id}/edit', name: 'local_accommodation_guests_edit')]
    public function edit(int $id, Request $request, ManagerRegistry $registry): Response
    {
        $em = $registry->getManager();
        $guest = $em->getRepository(Guest::class)->find($id);
        if (!$guest) {
            throw $this->createNotFoundException('Guest not found');
        }
        $form = $this->createForm(GuestType::class, $guest);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('local_accommodation_guests');
        }
        return $this->render('@LocalAccommodation/guests/edit.html.twig', [
            'form' => $form->createView(),
            'guest' => $guest,
            'sidebarMenu' => $this->getSidebarMenu(),
        ]);
    }

    #[Route('/local-accommodation/guests/{id}/delete', name: 'local_accommodation_guests_delete', methods: ['GET', 'POST'])]
    public function delete(int $id, Request $request, ManagerRegistry $registry): Response
    {
        $em = $registry->getManager();
        $guest = $em->getRepository(Guest::class)->find($id);
        if (!$guest) {
            throw $this->createNotFoundException('Guest not found');
        }
        if ($request->isMethod('POST')) {
            $em->remove($guest);
            $em->flush();
            return $this->redirectToRoute('local_accommodation_guests');
        }
        return $this->render('@LocalAccommodation/guests/delete.html.twig', [
            'guest' => $guest,
            'sidebarMenu' => $this->getSidebarMenu(),
        ]);
    }
}
