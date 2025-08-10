use Symfony\Component\HttpFoundation\Request;
#[Route('/local-accommodation/employees/new', name: 'local_accommodation_employees_new')]
public function new(Request $request, ManagerRegistry $registry): Response
{
$entityManager = $registry->getManager();
$employee = new Employee();
$error = null;

if ($request->isMethod('POST')) {
$employee->setName($request->request->get('name'));
$employee->setEmail($request->request->get('email'));
$employee->setPhone($request->request->get('phone'));
$entityManager->persist($employee);
$entityManager->flush();
return $this->redirectToRoute('local_accommodation_employees');
}

return $this->render('@LocalAccommodation/employees/new.html.twig', [
'employee' => $employee,
'sidebarMenu' => $this->getSidebarMenu(),
'error' => $error,
]);
}
<?php


namespace LocalAccommodationBundle\Controller;

use Symfony\Component\Yaml\Yaml;
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
