<?php

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
        $this->checkSession(); // Убедитесь, что пользователь вошел в систему

        $userId = $_SESSION['user_id'];

        // Получаем данные о пользователе и товарах из корзины
        $name = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $address = htmlspecialchars(trim($_POST['address']));
        $number = htmlspecialchars(trim($_POST['number']));

        // Получаем список товаров из корзины
        $userProducts = $this->userProduct->getAllByUserId($userId);

        if (empty($userProducts)) {
            header('Location: /cart'); // Корзина пуста, перенаправляем
            exit;
        }

        // Создаем заказ
        $orderId = $this->order->createOrder($userId, $name, $email, $address, $number);

        // Проверяем, был ли успешно создан заказ
        if ($orderId) {
            // Перебираем все товары в корзине и добавляем их к заказу
            foreach ($userProducts as $userProduct) {
                $productId = $userProduct['product_id'];
                $amount = $userProduct['amount'];

                // Получаем цену товара по его ID из таблицы products
                $productPrice = $this->product->getProductPriceById($productId);

                // Проверяем, успешно ли получена цена
                if ($productPrice === null) {
                    // Цена не найдена, можно обработать ошибку
                    echo "Не удалось получить цену для продукта с ID: $productId.";
                    continue; // Продолжаем с следующего продукта
                }

                $total = $productPrice * $amount; // Обчисляем общую стоимость

                // Создаем детали заказа
                $this->orderProduct->createOrderDetail($orderId, $productId, $amount, $total);
            }

            // Очищаем корзину
            $this->userProduct->clearCartByUserId($userId);

            // Перенаправляем на страницу успешного оформления заказа
            header('Location: /order/confirm');
            exit();
        } else {
            // Обработка ошибки при создании заказа
            echo "Не удалось создать заказ. Пожалуйста, попробуйте позже.";
        }
    }


    private function checkSession(): void {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login'); // Перенаправление на страницу логина
            exit;
        }
    }
}



