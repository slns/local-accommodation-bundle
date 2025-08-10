<?php



namespace LocalAccommodationBundle\Controller;

use Symfony\Component\Yaml\Yaml;
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
        $laundry = new Laundry();
        $form = $this->createForm(\LocalAccommodationBundle\Form\LaundryType::class, $laundry);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $registry->getManager();
            $em->persist($laundry);
            $em->flush();
            return $this->redirectToRoute('local_accommodation_laundry');
        }
        return $this->render('@LocalAccommodation/laundry/new.html.twig', [
            'form' => $form->createView(),
            'sidebarMenu' => $this->getSidebarMenu(),
        ]);
    }

    #[Route('/local-accommodation/laundry/{id}/edit', name: 'local_accommodation_laundry_edit')]
    public function edit(int $id, Request $request, ManagerRegistry $registry): Response
    {
        $em = $registry->getManager();
        $laundry = $em->getRepository(Laundry::class)->find($id);
        if (!$laundry) {
            throw $this->createNotFoundException('Laundry not found');
        }
        $form = $this->createForm(\LocalAccommodationBundle\Form\LaundryType::class, $laundry);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('local_accommodation_laundry');
        }
        return $this->render('@LocalAccommodation/laundry/edit.html.twig', [
            'form' => $form->createView(),
            'laundry' => $laundry,
            'sidebarMenu' => $this->getSidebarMenu(),
        ]);
    }

    #[Route('/local-accommodation/laundry/{id}/delete', name: 'local_accommodation_laundry_delete', methods: ['GET', 'POST'])]
    public function delete(int $id, Request $request, ManagerRegistry $registry): Response
    {
        $em = $registry->getManager();
        $laundry = $em->getRepository(Laundry::class)->find($id);
        if (!$laundry) {
            throw $this->createNotFoundException('Laundry not found');
        }
        if ($request->isMethod('POST')) {
            $em->remove($laundry);
            $em->flush();
            return $this->redirectToRoute('local_accommodation_laundry');
        }
        return $this->render('@LocalAccommodation/laundry/delete.html.twig', [
            'laundry' => $laundry,
            'sidebarMenu' => $this->getSidebarMenu(),
        ]);
    }
}
