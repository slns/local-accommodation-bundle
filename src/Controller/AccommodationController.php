<?php

namespace LocalAccommodationBundle\Controller;

use LocalAccommodationBundle\Entity\Accommodation;
use LocalAccommodationBundle\Form\AccommodationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class AccommodationController extends AbstractController
{
    #[Route('/local-accommodation/accommodations', name: 'local_accommodation_accommodations')]
    public function index(ManagerRegistry $registry): Response
    {
        $accommodations = $registry->getManager()->getRepository(Accommodation::class)->findAll();
        return $this->render('@LocalAccommodation/accommodations/index.html.twig', [
            'accommodations' => $accommodations
        ]);
    }

    #[Route('/local-accommodation/accommodations/new', name: 'local_accommodation_accommodations_new')]
    public function new(Request $request, ManagerRegistry $registry): Response
    {
        $accommodation = new Accommodation();
        $form = $this->createForm(AccommodationType::class, $accommodation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $registry->getManager();
            $em->persist($accommodation);
            $em->flush();
            return $this->redirectToRoute('local_accommodation_accommodations');
        }
        return $this->render('@LocalAccommodation/accommodations/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/local-accommodation/accommodations/{id}/edit', name: 'local_accommodation_accommodations_edit')]
    public function edit(int $id, Request $request, ManagerRegistry $registry): Response
    {
        $em = $registry->getManager();
        $accommodation = $em->getRepository(Accommodation::class)->find($id);
        if (!$accommodation) {
            throw $this->createNotFoundException('Accommodation not found');
        }
        $form = $this->createForm(AccommodationType::class, $accommodation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('local_accommodation_accommodations');
        }
        return $this->render('@LocalAccommodation/accommodations/edit.html.twig', [
            'form' => $form->createView(),
            'accommodation' => $accommodation,
        ]);
    }

    #[Route('/local-accommodation/accommodations/{id}/delete', name: 'local_accommodation_accommodations_delete', methods: ['GET', 'POST'])]
    public function delete(int $id, Request $request, ManagerRegistry $registry): Response
    {
        $em = $registry->getManager();
        $accommodation = $em->getRepository(Accommodation::class)->find($id);
        if (!$accommodation) {
            throw $this->createNotFoundException('Accommodation not found');
        }
        if ($request->isMethod('POST')) {
            $em->remove($accommodation);
            $em->flush();
            return $this->redirectToRoute('local_accommodation_accommodations');
        }
        return $this->render('@LocalAccommodation/accommodations/delete.html.twig', [
            'accommodation' => $accommodation,
        ]);
    }
}
