<?php

namespace Service;

use DataTransferObject\CreateOrderDTO;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;

class OrderService
{
    public function __construct(private Order $order,private UserProduct $userProduct,
                                private OrderProduct $orderProduct, private Product $product ){

    }
    public function create(CreateOrderDto $orderDTO){


        $userProducts = $this->userProduct->getAllByUserId($userId);

        if (empty($userProducts)) {
            header('Location: /cart');
            exit;
        }

        $orderId = $this->order->createOrder($userId, $orderDTO->getName(), $orderDTO->getEmail(), $orderDTO->getAddress(), $orderDTO->getNumber());

        if ($orderId) {
            foreach ($userProducts as $userProduct) {
                $productId = $userProduct->getProductId();
                $amount = $userProduct->getAmount();

                $product = $this->product->getProductById($productId);
                if ($product === null) {
                    echo "Не удалось получить информацию о продукте с ID: $productId.";
                    continue; // Можно продолжить с других продуктов
                }
                // Используйте price из объекта Product
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

}