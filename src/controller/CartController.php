<?php

class CartController
{
    private UserProduct $userProductModel;
    private User $userModel;
    private Product $productModel;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->userModel = new User();
        $this->productModel = new Product();
    }

    public function getCartPage(): void
    {
        $this->checkSession();

        $userId = $_SESSION['user_id'];

        // Получаем данные о пользователе
        $userData = $this->userModel->getOneById($userId);

        // Получаем список товаров в корзине
        $userProducts = $this->userProductModel->getAllByUserId($userId);

        if (empty($userProducts)) {

            $products = [];
        } else {
            // Извлекаем идентификаторы продуктов
            $productIds = array_column($userProducts, 'product_id');

            // Получаем все продукты по идентификаторам
            $productsDB = $this->productModel->getAllById($productIds);


            $productMap = [];
            foreach ($productsDB as $product) {
                $productMap[$product['id']] = $product;
            }

            // Добавляем количество товаров в массив
            foreach ($userProducts as $userProduct) {
                if (isset($productMap[$userProduct['product_id']])) {
                    $productMap[$userProduct['product_id']]['amount'] = $userProduct['amount'];
                }
            }

            // Переходим к массиву
            $products = array_values($productMap);
        }

        require_once './../view/cart.php';
    }

    private function checkSession(): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header('Location: /login');
        }
    }
}



