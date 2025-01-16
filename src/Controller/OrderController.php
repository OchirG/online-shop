<?php
namespace Controller;
use Model\Product;
use Model\OrderProduct;
use Model\Order;
use Model\UserProduct;
class OrderController {
    private Order $order;
    private OrderProduct $orderProduct;
    private UserProduct $userProduct;
    private Product $product;

    public function __construct() {
        $this->order = new Order();
        $this->orderProduct = new OrderProduct();
        $this->userProduct = new UserProduct();
        $this->product = new Product();
    }
    public function getOrderForm() {
        require_once './../view/order.php';
    }
    public function getOrderConfirmForm(){
        require_once './../view/order_confirm.php';
    }
    public function handleOrder(): void {
        $this->checkSession();

        $userId = $_SESSION['user_id'];
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $address = trim($_POST['address']);
        $number = trim($_POST['number']);

        $userProducts = $this->userProduct->getAllByUserId($userId);

        if (empty($userProducts)) {
            header('Location: /cart');
            exit;
        }

        $orderId = $this->order->createOrder($userId, $name, $email, $address, $number);

        if ($orderId) {
            foreach ($userProducts as $userProduct) {
                $productId = $userProduct->getProductId();
                $amount = $userProduct->getAmount();

                $product = $this->product->getProductById($productId);
                if ($product === null) {
                    echo "Не удалось получить информацию о продукте с ID: $productId.";

                }

                $total = $product->getPrice() * $amount;

                $this->orderProduct->createOrderDetail($orderId, $productId, $amount, $total);
            }

            $this->userProduct->clearCartByUserId($userId);

            header('Location: /order/confirm');
            exit();
        } else {
            echo "Не удалось создать заказ. Пожалуйста, попробуйте позже.";
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
                            $product->order_amount = $orderProduct->getAmount();
                            $product->order_price = $orderProduct->getTotal();
                        }
                    }
                }
                $order->products = $products;
            }
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



