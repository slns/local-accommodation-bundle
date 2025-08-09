
<?php

use Symfony\Component\Yaml\Yaml;

namespace LocalAccommodationBundle\Controller;

use LocalAccommodationBundle\Entity\Employee;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
