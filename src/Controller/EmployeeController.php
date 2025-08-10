<?php


namespace LocalAccommodationBundle\Controller;

use Symfony\Component\Yaml\Yaml;
use LocalAccommodationBundle\Entity\Employee;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class EmployeeController extends AbstractController
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

    #[Route('/local-accommodation/employees', name: 'local_accommodation_employees')]
    public function index(ManagerRegistry $registry): Response
    {
        $employees = $registry->getManager()->getRepository(Employee::class)->findAll();
        return $this->render('@LocalAccommodation/employees/index.html.twig', [
            'employees' => $employees,
            'sidebarMenu' => $this->getSidebarMenu(),
        ]);
    }

    #[Route('/local-accommodation/employees/new', name: 'local_accommodation_employees_new')]
    public function new(Request $request, ManagerRegistry $registry): Response
    {
        $employee = new Employee();
        $form = $this->createForm(\LocalAccommodationBundle\Form\EmployeeType::class, $employee);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $registry->getManager();
            $em->persist($employee);
            $em->flush();
            return $this->redirectToRoute('local_accommodation_employees');
        }
        return $this->render('@LocalAccommodation/employees/new.html.twig', [
            'form' => $form->createView(),
            'sidebarMenu' => $this->getSidebarMenu(),
        ]);
    }

    #[Route('/local-accommodation/employees/{id}/edit', name: 'local_accommodation_employees_edit')]
    public function edit(int $id, Request $request, ManagerRegistry $registry): Response
    {
        $em = $registry->getManager();
        $employee = $em->getRepository(Employee::class)->find($id);
        if (!$employee) {
            throw $this->createNotFoundException('Employee not found');
        }
        $form = $this->createForm(\LocalAccommodationBundle\Form\EmployeeType::class, $employee);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('local_accommodation_employees');
        }
        return $this->render('@LocalAccommodation/employees/edit.html.twig', [
            'form' => $form->createView(),
            'employee' => $employee,
            'sidebarMenu' => $this->getSidebarMenu(),
        ]);
    }

    #[Route('/local-accommodation/employees/{id}/delete', name: 'local_accommodation_employees_delete', methods: ['GET', 'POST'])]
    public function delete(int $id, Request $request, ManagerRegistry $registry): Response
    {
        $em = $registry->getManager();
        $employee = $em->getRepository(Employee::class)->find($id);
        if (!$employee) {
            throw $this->createNotFoundException('Employee not found');
        }
        if ($request->isMethod('POST')) {
            $em->remove($employee);
            $em->flush();
            return $this->redirectToRoute('local_accommodation_employees');
        }
        return $this->render('@LocalAccommodation/employees/delete.html.twig', [
            'employee' => $employee,
            'sidebarMenu' => $this->getSidebarMenu(),
        ]);
    }
}
