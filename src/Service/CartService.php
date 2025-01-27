<?php
namespace Service;

use Model\UserProduct;
use Model\Product;
use DataTransferObject\CartDTO;

class CartService {
    private UserProduct $userProduct;
    private Product $product;


    public function __construct() {
        $this->userProduct = new UserProduct();
        $this->product = new Product();
    }

    public function addProductToUserCart(CartDTO $addProductDTO): bool {
        return $this->userProduct->getAddProduct($addProductDTO->getUserId(), $addProductDTO->getProductId(), $addProductDTO->getAmount());
    }

    public function getUserCartProducts(int $userId): array
    {
        $userProducts = $this->userProduct->getAllByUserId($userId);
        $products = [];

        if (!empty($userProducts)) {
            $productIds = array_map(fn($userProduct) => $userProduct->getProductId(), $userProducts);
            $productsDB = $this->product->getAllById($productIds);

            $productMap = [];
            foreach ($productsDB as $product) {
                $productMap[$product->getId()] = $product;
            }

            foreach ($userProducts as $userProduct) {
                $productId = $userProduct->getProductId();
                $amount = $userProduct->getAmount();

                if (isset($productMap[$productId])) {
                    $productMap[$productId]->setAmount($amount);
                    $products[] = $productMap[$productId];
                }
            }
        }

        return $products;
    }

}

