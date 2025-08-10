use Symfony\Component\HttpFoundation\Request;
#[Route('/local-accommodation/payments/new', name: 'local_accommodation_payments_new')]
public function new(Request $request, ManagerRegistry $registry): Response
{
$entityManager = $registry->getManager();
$payment = new Payment();
$error = null;

if ($request->isMethod('POST')) {
$payment->setAmount((float)$request->request->get('amount'));
$payment->setMethod($request->request->get('method'));
$date = $request->request->get('date');
if ($date) {
$payment->setDate(new \DateTime($date));
}
$entityManager->persist($payment);
$entityManager->flush();
return $this->redirectToRoute('local_accommodation_payments');
}

return $this->render('@LocalAccommodation/payments/new.html.twig', [
'payment' => $payment,
'sidebarMenu' => $this->getSidebarMenu(),
'error' => $error,
]);
}
<?php


namespace LocalAccommodationBundle\Controller;

use Symfony\Component\Yaml\Yaml;
use LocalAccommodationBundle\Entity\Payment;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
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
    #[Route('/local-accommodation/payments', name: 'local_accommodation_payments')]
    public function index(ManagerRegistry $registry): Response
    {
        $payments = $registry->getManager()->getRepository(Payment::class)->findAll();
        return $this->render('@LocalAccommodation/payments/index.html.twig', [
            'payments' => $payments,
            'sidebarMenu' => $this->getSidebarMenu(),
        ]);
    }
}
