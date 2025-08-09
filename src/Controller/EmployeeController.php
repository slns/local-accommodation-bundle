<?php

namespace LocalAccommodationBundle\Controller;

use LocalAccommodationBundle\Entity\Employee;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeeController extends AbstractController
{
    #[Route('/local-accommodation/employees', name: 'local_accommodation_employees')]
    public function index(ManagerRegistry $registry): Response
    {
        $employees = $registry->getManager()->getRepository(Employee::class)->findAll();
        return $this->render('@LocalAccommodation/employees/index.html.twig', [
            'employees' => $employees
        ]);
    }
}
