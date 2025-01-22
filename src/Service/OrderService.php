<?php

namespace Service;

use DataTransferObject\CreateOrderDTO;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;

class OrderService {
    private Order $order;
    private UserProduct $userProduct;
    private OrderProduct $orderProduct;
    private Product $product;

    public function __construct(){
        $this->order = new Order();
        $this->userProduct = new UserProduct();
        $this->orderProduct = new OrderProduct();
        $this->product = new Product();
    }

    public function create(CreateOrderDTO $orderDTO, int $userId): bool {
        $userProducts = $this->userProduct->getAllByUserId($userId);
        if (empty($userProducts)) {
            return false;
        }

        $orderId = $this->order->createOrder($userId, $orderDTO->getName(), $orderDTO->getEmail(), $orderDTO->getAddress(), $orderDTO->getNumber());

        if ($orderId) {
            foreach ($userProducts as $userProduct) {
                $productId = $userProduct->getProductId();
                $amount = $userProduct->getAmount();

                $product = $this->product->getProductById($productId);
                if ($product === null) {
                    echo "Не удалось получить информацию о продукте с ID: $productId.";
                    continue;
                }

                $total = $product->getPrice() * $amount;
                $this->orderProduct->createOrderDetail($orderId, $productId, $amount, $total);
            }

            $this->userProduct->clearCartByUserId($userId);
            return true;
        }

        return false;
    }


    }
