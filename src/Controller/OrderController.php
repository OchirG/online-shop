<?php
namespace Controller;

use DataTransferObject\CreateOrderDTO;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;
use Request\OrderRequest;
use Service\OrderService;

class OrderController {
    private  Product $product;
    private Order $order;
    private OrderProduct $orderProduct;
    private UserProduct $userProduct;
    private OrderService $orderService;

    public function __construct() {
        $this->userProduct = new UserProduct();
        $this->orderService = new OrderService();
        $this->orderProduct = new OrderProduct();
        $this->product = new Product();
        $this->order = new Order();
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

        $userId = $_SESSION['user_id'];
        $name = $request->getName();
        $email = $request->getEmail();
        $address = $request->getAddress();
        $number = $request->getNumber();

        if ($userProducts = $this->userProduct->getAllByUserId($userId)) {

            $dto = new CreateOrderDTO($name, $email, $address, $number);
            if ($this->orderService->create($dto, $userId)) {
                header('Location: /order/confirm');
                exit();
            } else {
                echo "Не удалось создать заказ. Пожалуйста, попробуйте позже.";
            }
        } else {
            header('Location: /cart');
            exit;
        }
    }

    public function getOrders()
    {
        $this->checkSession();
        $userId = $_SESSION['user_id'];
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
                            $total += $orderProduct->getTotal(); // Считаем общую стоимость заказа
                        }
                    }
                }
                $order->setProducts($products);
            }

            // Здесь можно передать $total в представление, например, через метод установки или настраиваемый метод в классе Order.
            $order->setTotal($total); // Если у вас есть метод установки общей суммы заказов в классе Order
        }

        require_once './../view/orders.php';
    }
    private function checkSession(): void {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }
}



