<?php
namespace Controller;

use DataTransferObject\CreateOrderDTO;
use Model\Model;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Request\OrderRequest;
use Service\Auth\AuthServiceInterface;
use Service\OrderService;

class OrderController {
    private  Product $product;
    private Order $order;
    private OrderProduct $orderProduct;

    private OrderService $orderService;
    private AuthServiceInterface $authService;


    public function __construct(OrderService $orderService, AuthServiceInterface $authService, Product $product, Order $order, OrderProduct $orderProduct) {
        $this->orderService = $orderService;
        $this->orderProduct = $orderProduct;
        $this->product = $product;
        $this->order = $order;
        $this->authService = $authService;
    }

    public function getOrderForm() {
        require_once './../view/order.php';
    }

    public function getOrderConfirmForm() {
        require_once './../view/order_confirm.php';
    }

    public function handleOrder(OrderRequest $request): void {
        $this->checkSession();

        $errors = $request->validate();
        if (!empty($errors)) {
            return;
        }

        $userId = $this->authService->getCurrentUser()->getId();
        $name = $request->getName();
        $email = $request->getEmail();
        $address = $request->getAddress();
        $number = $request->getNumber();

        $dto = new CreateOrderDTO($name, $email, $address, $number);

        if ($this->orderService->create($dto, $userId)) {
            header('Location: /order/confirm');
            exit();
        } else {
            echo "Не удалось создать заказ. Пожалуйста, попробуйте позже.";
        }

        header('Location: /cart');
        exit();
    }

    public function getOrders()
    {

        $pdo = Model::getPdo();
        $pdo->beginTransaction();
        try {
            $this->checkSession();
            $userId = $this->authService->getCurrentUser()->getId();
            $orders = $this->order->getAllByUserId($userId);

            if (empty($orders)) {
                echo 'У вас нет заказов.';
                return;
            }

            foreach ($orders as &$order) {
                $orderProducts = $this->orderProduct->getByOrderId($order->getId());
                $total = 0;

                if (empty($orderProducts)) {
                    echo 'Не найдено ни одного товара для заказа с идентификатором: ' . $order->getId();
                    continue;
                }

                $productIds = [];
                foreach ($orderProducts as $orderProduct) {
                    $productIds[] = $orderProduct->getProductId();
                }

                if (!empty($productIds)) {
                    $products = $this->product->getAllById($productIds);
                    foreach ($products as $product) {
                        foreach ($orderProducts as $orderProduct) {
                            if ($product->getId() === $orderProduct->getProductId()) {
                                $product->setOrderAmount($orderProduct->getAmount());
                                $product->setOrderPrice($orderProduct->getTotal());
                                $total += $orderProduct->getTotal();
                            }
                        }
                    }
                    $order->setProducts($products);
                }

                $order->setTotal($total);
            }

            require_once './../view/orders.php';
        }catch (\Exception $e) {
            $pdo->rollBack();
            echo 'Произошла ошибка' . $e->getMessage();
        }
        $pdo->commit();
    }
    private function checkSession(): void {

        if (!$this->authService->check()) {
            header('Location: /login');
            exit;
        }
    }
}



