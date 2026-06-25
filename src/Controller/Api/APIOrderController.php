<?php

namespace App\Controller\Api;

use App\Entity\Order;
use App\Entity\Orderitem;
use App\Entity\Gem;
use App\Entity\Jewelries;
use App\Entity\Gembundles;
use App\Entity\Customjewelries;
use App\Entity\User;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/orders')]
class OrderApiController extends AbstractController
{
    // -------------------------------------------------------
    // GET /api/orders
    // Returns all orders (with their items)
    // -------------------------------------------------------
    #[Route('', name: 'api_order_list', methods: ['GET'])]
    public function list(OrderRepository $orderRepository): JsonResponse
    {
        $orders = $orderRepository->findAll();

        $data = array_map(fn(Order $order) => $this->serializeOrder($order), $orders);

        return $this->json([
            'success' => true,
            'orders'  => $data,
        ]);
    }

    // -------------------------------------------------------
    // GET /api/orders/{id}
    // Returns a single order with its items
    // -------------------------------------------------------
    #[Route('/{id}', name: 'api_order_show', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $em): JsonResponse
    {
        $order = $em->getRepository(Order::class)->find($id);

        if (!$order) {
            return $this->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        return $this->json([
            'success' => true,
            'order'   => $this->serializeOrder($order),
        ]);
    }

    // -------------------------------------------------------
    // POST /api/orders
    // Creates a new order
    //
    // Expected JSON body:
    // {
    //   "customer_id": 1,       ← ID of the user placing the order
    //   "status": "pending"     ← optional, defaults to "pending"
    // }
    // -------------------------------------------------------
    #[Route('', name: 'api_order_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return $this->json(['success' => false, 'message' => 'Invalid JSON body'], 400);
        }

        // Validate required fields
        if (empty($data['customer_id'])) {
            return $this->json(['success' => false, 'message' => 'customer_id is required'], 400);
        }

        // Find the customer user
        $customer = $em->getRepository(User::class)->find($data['customer_id']);
        if (!$customer) {
            return $this->json(['success' => false, 'message' => 'Customer not found'], 404);
        }

        // Create the order
        $order = new Order();
        $order->setCustomer($customer);
        $order->setCreatedBy($customer);
        $order->setStatus($data['status'] ?? 'pending');
        $order->setCreatedAt(new \DateTime());
        $order->setAmount('0.00');

        $em->persist($order);
        $em->flush();

        return $this->json([
            'success'  => true,
            'message'  => 'Order created successfully',
            'order_id' => $order->getId(),
            'order'    => $this->serializeOrder($order),
        ], 201);
    }

    // -------------------------------------------------------
    // POST /api/orders/{id}/items
    // Adds items to an existing order
    //
    // Expected JSON body:
    // {
    //   "items": [
    //     { "type": "gem",     "product_id": 1, "quantity": 2 },
    //     { "type": "jewelry", "product_id": 3, "quantity": 1 },
    //     { "type": "bundle",  "product_id": 2, "quantity": 1 },
    //     { "type": "custom",  "product_id": 4, "quantity": 3 }
    //   ]
    // }
    // -------------------------------------------------------
    #[Route('/{id}/items', name: 'api_order_add_items', methods: ['POST'])]
    public function addItems(int $id, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $order = $em->getRepository(Order::class)->find($id);

        if (!$order) {
            return $this->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        $data = json_decode($request->getContent(), true);

        if (!$data || empty($data['items'])) {
            return $this->json(['success' => false, 'message' => 'items array is required'], 400);
        }

        $createdItems = [];
        $errors       = [];

        foreach ($data['items'] as $index => $itemData) {
            $type       = $itemData['type']       ?? null;
            $productId  = $itemData['product_id'] ?? null;
            $quantity   = $itemData['quantity']   ?? null;

            // Validate each item
            if (!$type || !$productId || !$quantity || $quantity <= 0) {
                $errors[] = "Item #{$index}: type, product_id, and quantity (> 0) are required";
                continue;
            }

            // Find the product based on type
            $product = null;
            switch ($type) {
                case 'gem':
                    $product = $em->getRepository(Gem::class)->find($productId);
                    break;
                case 'jewelry':
                    $product = $em->getRepository(Jewelries::class)->find($productId);
                    break;
                case 'bundle':
                    $product = $em->getRepository(Gembundles::class)->find($productId);
                    break;
                case 'custom':
                    $product = $em->getRepository(Customjewelries::class)->find($productId);
                    break;
                default:
                    $errors[] = "Item #{$index}: unknown type '{$type}'. Use gem, jewelry, bundle, or custom";
                    continue 2;
            }

            if (!$product) {
                $errors[] = "Item #{$index}: {$type} with ID {$productId} not found";
                continue;
            }

            // Create the order item
            $orderItem = new Orderitem();
            $orderItem->setOrder($order);
            $orderItem->setQuantity((int) $quantity);
            $orderItem->setPriceSnapshot((string) $product->getPrice());

            // Assign the correct product type
            match ($type) {
                'gem'     => $orderItem->setGem($product),
                'jewelry' => $orderItem->setJewelry($product),
                'bundle'  => $orderItem->setGembundle($product),
                'custom'  => $orderItem->setCustomjewelries($product),
            };

            $em->persist($orderItem);
            $createdItems[] = $orderItem;
        }

        // If no valid items were created, return error
        if (empty($createdItems)) {
            return $this->json([
                'success' => false,
                'message' => 'No valid items to add',
                'errors'  => $errors,
            ], 400);
        }

        $em->flush();

        // Recalculate order total
        $total = 0.0;
        foreach ($order->getOrderitems() as $item) {
            $total += $item->getQuantity() * (float) $item->getPriceSnapshot();
        }
        $order->setAmount((string) $total);
        $em->flush();

        return $this->json([
            'success'       => true,
            'message'       => count($createdItems) . ' item(s) added successfully',
            'items_added'   => count($createdItems),
            'errors'        => $errors, // partial errors if some items failed
            'order'         => $this->serializeOrder($order),
        ], 201);
    }

    // -------------------------------------------------------
    // Helper: serialize an Order to array for JSON response
    // -------------------------------------------------------
    private function serializeOrder(Order $order): array
    {
        $items = [];
        foreach ($order->getOrderitems() as $item) {
            $productName = 'Unknown';
            $productType = 'unknown';

            if ($item->getGem()) {
                $gem = $item->getGem();
                // Gem doesn't have a name field, so we create a descriptive name from its properties
                $productName = "{$gem->getColor()} {$gem->getCut()} - {$gem->getCarat()}ct";
                $productType = 'gem';
            } elseif ($item->getJewelry()) {
                $productName = $item->getJewelry()->getName();
                $productType = 'jewelry';
            } elseif ($item->getGembundle()) {
                $productName = $item->getGembundle()->getName();
                $productType = 'bundle';
            } elseif ($item->getCustomjewelries()) {
                // Custom jewelry doesn't have a name field, so we use a descriptive label
                $custom = $item->getCustomjewelries();
                $productName = "Custom Jewelry - {$custom->getId()}";
                $productType = 'custom';
            }

            $items[] = [
                'id'             => $item->getId(),
                'product_type'   => $productType,
                'product_name'   => $productName,
                'quantity'       => $item->getQuantity(),
                'price_snapshot' => $item->getPriceSnapshot(),
                'subtotal'       => $item->getQuantity() * (float) $item->getPriceSnapshot(),
            ];
        }

        return [
            'id'         => $order->getId(),
            'status'     => $order->getStatus(),
            'amount'     => $order->getAmount(),
            'created_at' => $order->getCreatedAt()?->format('Y-m-d H:i:s'),
            'customer'   => [
                'id'    => $order->getCustomer()?->getId(),
                'email' => $order->getCustomer()?->getEmail(),
            ],
            'items'      => $items,
        ];
    }
}