<?php

namespace LocalAccommodationBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use LocalAccommodationBundle\Entity\Guest;
use LocalAccommodationBundle\Form\GuestType;

class GuestController extends AbstractController
{
    #[Route('/local-accommodation/hospedes', name: 'local_accommodation_hospedes')]
    public function index(ManagerRegistry $registry): Response
    {
        $guests = $registry->getManager()->getRepository(Guest::class)->findAll();
        return $this->render('@LocalAccommodation/hospedes/index.html.twig', [
            'hospedes' => $hospedes
        ]);
    }

    #[Route('/local-accommodation/hospedes/new', name: 'local_accommodation_hospedes_new')]
    public function new(Request $request, ManagerRegistry $registry): Response
    {
        $guest = new Guest();
        $form = $this->createForm(GuestType::class, $guest);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $registry->getManager();
            $em->persist($hospede);
            $em->flush();
            return $this->redirectToRoute('local_accommodation_hospedes');
        }
        return $this->render('@LocalAccommodation/hospedes/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/local-accommodation/hospedes/{id}/edit', name: 'local_accommodation_hospedes_edit')]
    public function edit(int $id, Request $request, ManagerRegistry $registry): Response
    {
        $em = $registry->getManager();
        $guest = $em->getRepository(Guest::class)->find($id);
        if (!$hospede) {
            throw $this->createNotFoundException('Hóspede não encontrado');
        }
        $form = $this->createForm(GuestType::class, $guest);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('local_accommodation_hospedes');
        }
        return $this->render('@LocalAccommodation/hospedes/edit.html.twig', [
            'form' => $form->createView(),
            'hospede' => $hospede,
        ]);
    }

    #[Route('/local-accommodation/hospedes/{id}/delete', name: 'local_accommodation_hospedes_delete', methods: ['GET', 'POST'])]
    public function delete(int $id, Request $request, ManagerRegistry $registry): Response
    {
        $em = $registry->getManager();
        $guest = $em->getRepository(Guest::class)->find($id);
        if (!$hospede) {
            throw $this->createNotFoundException('Hóspede não encontrado');
        }
        if ($request->isMethod('POST')) {
            $em->remove($hospede);
            $em->flush();
            return $this->redirectToRoute('local_accommodation_hospedes');
        }
        return $this->render('@LocalAccommodation/hospedes/delete.html.twig', [
            'hospede' => $hospede,
        ]);
    }
}
