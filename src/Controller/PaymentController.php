<?php


namespace LocalAccommodationBundle\Controller;

use Symfony\Component\Yaml\Yaml;
use LocalAccommodationBundle\Entity\Payment;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


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

    #[Route('/local-accommodation/payments/new', name: 'local_accommodation_payments_new')]
    public function new(Request $request, ManagerRegistry $registry): Response
    {
        $payment = new Payment();
        $form = $this->createForm(\LocalAccommodationBundle\Form\PaymentType::class, $payment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $registry->getManager();
            $em->persist($payment);
            $em->flush();
            return $this->redirectToRoute('local_accommodation_payments');
        }
        return $this->render('@LocalAccommodation/payments/new.html.twig', [
            'form' => $form->createView(),
            'sidebarMenu' => $this->getSidebarMenu(),
        ]);
    }

    #[Route('/local-accommodation/payments/{id}/edit', name: 'local_accommodation_payments_edit')]
    public function edit(int $id, Request $request, ManagerRegistry $registry): Response
    {
        $em = $registry->getManager();
        $payment = $em->getRepository(Payment::class)->find($id);
        if (!$payment) {
            throw $this->createNotFoundException('Payment not found');
        }
        $form = $this->createForm(\LocalAccommodationBundle\Form\PaymentType::class, $payment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('local_accommodation_payments');
        }
        return $this->render('@LocalAccommodation/payments/edit.html.twig', [
            'form' => $form->createView(),
            'payment' => $payment,
            'sidebarMenu' => $this->getSidebarMenu(),
        ]);
    }

    #[Route('/local-accommodation/payments/{id}/delete', name: 'local_accommodation_payments_delete', methods: ['GET', 'POST'])]
    public function delete(int $id, Request $request, ManagerRegistry $registry): Response
    {
        $em = $registry->getManager();
        $payment = $em->getRepository(Payment::class)->find($id);
        if (!$payment) {
            throw $this->createNotFoundException('Payment not found');
        }
        if ($request->isMethod('POST')) {
            $em->remove($payment);
            $em->flush();
            return $this->redirectToRoute('local_accommodation_payments');
        }
        return $this->render('@LocalAccommodation/payments/delete.html.twig', [
            'payment' => $payment,
            'sidebarMenu' => $this->getSidebarMenu(),
        ]);
    }
}
