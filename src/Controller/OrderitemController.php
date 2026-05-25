<?php

namespace App\Controller;

use App\Entity\Orderitem;
use App\Entity\Order;
use App\Form\OrderitemType;
use App\Repository\OrderitemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\EntityLoggerService;

#[Route('/orderitem')]
final class OrderitemController extends AbstractController
{
    #[Route('', name: 'app_orderitem_index', methods: ['GET'])]
    public function index(OrderitemRepository $orderitemRepository): Response
    {
        return $this->render('orderitem/index.html.twig', [
            'orderitems' => $orderitemRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_orderitem_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, EntityLoggerService $entityLogger): Response
    {
        $orderItem = new Orderitem();
        
        // Get the currently logged-in user
        $currentUser = $this->getUser();
        
        // Get order_id from query parameter
        $orderId = $request->query->get('order_id');
        $order = null;
        
        if ($orderId) {
            $order = $entityManager->getRepository(Order::class)->find($orderId);
            if ($order) {
                $orderItem->setOrder($order);
            }
        }

        $form = $this->createForm(OrderitemType::class, $orderItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle unmapped quantity fields
            $gemQuantity = $form->get('gem_quantity')->getData();
            $jewelryQuantity = $form->get('jewelry_quantity')->getData();
            $bundleQuantity = $form->get('bundle_quantity')->getData();
            
            $createdItems = []; // Track created items for logging
            
            // Create SEPARATE OrderItem for EACH selected product type
            // Handle Gem
            if ($orderItem->getGem() && $gemQuantity && $gemQuantity > 0) {
                $gemOrderItem = new Orderitem();
                $gemOrderItem->setGem($orderItem->getGem());
                $gemOrderItem->setQuantity($gemQuantity);
                $gemOrderItem->setPriceSnapshot($orderItem->getGem()->getPrice());
                $gemOrderItem->setOrder($order);
                $entityManager->persist($gemOrderItem);
                $createdItems[] = $gemOrderItem;
            }
            
            // Handle Jewelry
            if ($orderItem->getJewelry() && $jewelryQuantity && $jewelryQuantity > 0) {
                $jewelryOrderItem = new Orderitem();
                $jewelryOrderItem->setJewelry($orderItem->getJewelry());
                $jewelryOrderItem->setQuantity($jewelryQuantity);
                $jewelryOrderItem->setPriceSnapshot($orderItem->getJewelry()->getPrice());
                $jewelryOrderItem->setOrder($order);
                $entityManager->persist($jewelryOrderItem);
                $createdItems[] = $jewelryOrderItem;
            }
            
            // Handle Bundle
            if ($orderItem->getGembundle() && $bundleQuantity && $bundleQuantity > 0) {
                $bundleOrderItem = new Orderitem();
                $bundleOrderItem->setGembundle($orderItem->getGembundle());
                $bundleOrderItem->setQuantity($bundleQuantity);
                $bundleOrderItem->setPriceSnapshot($orderItem->getGembundle()->getPrice());
                $bundleOrderItem->setOrder($order);
                $entityManager->persist($bundleOrderItem);
                $createdItems[] = $bundleOrderItem;
            }
            
            // Handle Custom Jewelry (if you have this field)
            // if ($orderItem->getCustomjewelries() && $customQuantity && $customQuantity > 0) {
            //     $customOrderItem = new Orderitem();
            //     $customOrderItem->setCustomjewelries($orderItem->getCustomjewelries());
            //     $customOrderItem->setQuantity($customQuantity);
            //     $customOrderItem->setPriceSnapshot($orderItem->getCustomjewelries()->getPrice());
            //     $customOrderItem->setOrder($order);
            //     $entityManager->persist($customOrderItem);
            //     $createdItems[] = $customOrderItem;
            // }
            
            // DO NOT persist the original $orderItem (it has mixed data)
            // Only persist if user selected NO products (should be prevented by validation)
            if (empty($createdItems)) {
                $this->addFlash('error', 'Please select at least one product with quantity greater than 0.');
                return $this->render('orderitem/new.html.twig', [
                    'form' => $form->createView(),
                    'order' => $order,
                    'current_user' => $currentUser,
                ]);
            }
            
            $entityManager->flush();
            
            // UPDATE ORDER TOTAL
            if ($order) {
                $this->recalculateOrderTotal($order, $entityManager);
            }

            // LOG ALL CREATED ITEMS
            foreach ($createdItems as $item) {
                $entityLogger->logCreate($item);
            }
            
            $itemCount = count($createdItems);
            $this->addFlash('success', "{$itemCount} item(s) added to order successfully!");
            
            // REDIRECT TO ORDER SHOW PAGE
            return $this->redirectToRoute('app_order_show', ['id' => $order->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('orderitem/new.html.twig', [
            'form' => $form->createView(),
            'order' => $order,
            'current_user' => $currentUser,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_orderitem_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Orderitem $orderitem, EntityManagerInterface $entityManager, EntityLoggerService $entityLogger): Response
    {
        // Get current order before changes
        $order = $orderitem->getOrder();
        
        // Pre-populate form with current data
        $form = $this->createForm(OrderitemType::class, $orderitem);
        
        // Set initial values for unmapped quantity fields
        $currentQuantity = $orderitem->getQuantity();
        if ($orderitem->getGem()) {
            $form->get('gem_quantity')->setData($currentQuantity);
        } elseif ($orderitem->getJewelry()) {
            $form->get('jewelry_quantity')->setData($currentQuantity);
        } elseif ($orderitem->getGembundle()) {
            $form->get('bundle_quantity')->setData($currentQuantity);
        }
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle unmapped quantity fields
            $gemQuantity = $form->get('gem_quantity')->getData();
            $jewelryQuantity = $form->get('jewelry_quantity')->getData();
            $bundleQuantity = $form->get('bundle_quantity')->getData();
            
            // IMPORTANT: For edit, we need to clear other product types since ONE OrderItem = ONE product
            // User can only change to a different single product type
            
            // Clear all product types first
            $orderitem->setGem(null);
            $orderitem->setJewelry(null);
            $orderitem->setGembundle(null);
            $orderitem->setCustomjewelries(null);
            
            // Then set the selected one
            $quantity = 0;
            $price = 0.0;
            
            if ($gemQuantity && $gemQuantity > 0 && $orderitem->getGem()) {
                $quantity = $gemQuantity;
                $price = $orderitem->getGem()->getPrice();
            } elseif ($jewelryQuantity && $jewelryQuantity > 0 && $orderitem->getJewelry()) {
                $quantity = $jewelryQuantity;
                $price = $orderitem->getJewelry()->getPrice();
            } elseif ($bundleQuantity && $bundleQuantity > 0 && $orderitem->getGembundle()) {
                $quantity = $bundleQuantity;
                $price = $orderitem->getGembundle()->getPrice();
            }
            
            if ($quantity > 0) {
                $orderitem->setQuantity($quantity);
                $orderitem->setPriceSnapshot($price);
                
                $entityManager->flush();
                
                // UPDATE ORDER TOTAL
                if ($order) {
                    $this->recalculateOrderTotal($order, $entityManager);
                }
                
                // Get changes for logging
                $unitOfWork = $entityManager->getUnitOfWork();
                $unitOfWork->computeChangeSets();
                $orderitemChanges = $unitOfWork->getEntityChangeSet($orderitem);
                
                $entityLogger->logUpdate($orderitem, $orderitemChanges);
                
                $this->addFlash('success', 'Order item updated successfully!');
            } else {
                $this->addFlash('error', 'Quantity must be greater than 0.');
                return $this->render('orderitem/edit.html.twig', [
                    'orderitem' => $orderitem,
                    'form' => $form->createView(),
                ]);
            }
            
            // REDIRECT TO ORDER SHOW PAGE
            return $this->redirectToRoute('app_order_show', ['id' => $orderitem->getOrder()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('orderitem/edit.html.twig', [
            'orderitem' => $orderitem,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_orderitem_delete', methods: ['POST'])]
    public function delete(Request $request, Orderitem $orderitem, EntityManagerInterface $entityManager, EntityLoggerService $entityLogger): Response
    {
        if ($this->isCsrfTokenValid('delete'.$orderitem->getId(), $request->getPayload()->getString('_token'))) {
            // Get order before deletion
            $order = $orderitem->getOrder();
            
            // LOG BEFORE deletion
            $entityLogger->logDelete($orderitem);
            
            $entityManager->remove($orderitem);
            $entityManager->flush();
            
            // UPDATE ORDER TOTAL AFTER DELETION
            if ($order) {
                $this->recalculateOrderTotal($order, $entityManager);
            }
            
            $this->addFlash('success', 'Order item deleted successfully!');
        }

        return $this->redirectToRoute('app_order_show', ['id' => $order->getId()], Response::HTTP_SEE_OTHER);
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
        $entityManager->flush();
    }
}