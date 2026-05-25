<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\EntityLoggerService;

#[Route('/order')]
final class OrderController extends AbstractController
{
    #[Route('', name: 'app_order_index', methods: ['GET'])]
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('order/index.html.twig', [
            'orders' => $orderRepository->findAll(),
        ]);
        }
        

            
    #[Route('/new', name: 'app_order_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, EntityLoggerService $entityLogger): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        $order = new Order();
        $currentUser = $this->getUser();
        
        // Set defaults
        $order->setCustomer($currentUser); // Default to current user
        $order->setStatus('pending');      // Default status
        $order->setCreatedAt(new \DateTime());
        $order->setCreatedBy($currentUser);
        $order->setAmount(0);              // Will be calculated later
        
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($order);
            $entityManager->flush();
            
            $entityLogger->logCreate($order);
            
            $this->addFlash('success', 'Order created! Now add items.');
            
            // Go to add items page
            return $this->redirectToRoute('app_orderitem_new', [
                'order_id' => $order->getId()
            ]);
        }

        return $this->render('order/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_order_show', methods: ['GET'])]
    public function show(?Order $order): Response
    {
        if (!$order) {
            throw $this->createNotFoundException('Order not found');
        }

        return $this->render('order/show.html.twig', [
            'order' => $order,
        ]);
    }#[Route('/{id}/edit', name: 'app_order_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, ?Order $order, EntityManagerInterface $entityManager, EntityLoggerService $entityLogger): Response
{
    if (!$order) {
        throw $this->createNotFoundException('Order not found');
    }

    $user = $this->getUser();
    if (!$this->isGranted('ROLE_ADMIN') && $order->getCreatedBy() !== $user) {
        throw $this->createAccessDeniedException('You cannot edit this order.');
    }

    $form = $this->createForm(OrderType::class, $order);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Recalculate total just in case
        $this->recalculateOrderTotal($order, $entityManager);
        
        $entityManager->flush();
        
        // Log the update
        $unitOfWork = $entityManager->getUnitOfWork();
        $unitOfWork->computeChangeSets();
        $orderChanges = $unitOfWork->getEntityChangeSet($order);
        $entityLogger->logUpdate($order, $orderChanges);
        
        $this->addFlash('success', 'Order updated successfully!');
        
        return $this->redirectToRoute('app_order_show', ['id' => $order->getId()], Response::HTTP_SEE_OTHER);
    }

    // Show form errors if any
    if ($form->isSubmitted() && !$form->isValid()) {
        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($errors as $error) {
            $this->addFlash('error', $error);
        }
    }

    return $this->render('order/edit.html.twig', [
        'order' => $order,
        'form' => $form->createView(),
    ]);
}

/**
 * Recalculate and update the total amount of an order
 */
private function recalculateOrderTotal(Order $order, EntityManagerInterface $entityManager): void
{
    $total = 0.0;
    
    foreach ($order->getOrderitems() as $item) {
        $total += $item->getQuantity() * (float) $item->getPriceSnapshot();
    }
    
    $order->setAmount($total);
    $entityManager->persist($order);
}

    #[Route('/{id}/manage-items', name: 'app_order_manage_items', methods: ['GET'])]
    public function manageItems(?Order $order, EntityManagerInterface $entityManager): Response
    {
        if (!$order) {
            throw $this->createNotFoundException('Order not found');
        }

        return $this->render('order/manage_items.html.twig', [
            'order' => $order,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_order_delete', methods: ['POST'])] // CHANGED PATH
    public function delete(Request $request, ?Order $order, EntityManagerInterface $entityManager, EntityLoggerService $entityLogger): Response
    {
        if (!$order) {
            throw $this->createNotFoundException('Order not found');
        }

        $user = $this->getUser();
        if (!$this->isGranted('ROLE_ADMIN') && $order->getCreatedBy() !== $user) {
            throw $this->createAccessDeniedException('You cannot delete this order.');
        }

        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->getPayload()->getString('_token'))) {
            
            // LOG BEFORE deletion
            $entityLogger->logDelete($order);
            
            $entityManager->remove($order);
            $entityManager->flush();
            
            $this->addFlash('success', 'Order deleted successfully!');
        }

        return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
    }
}