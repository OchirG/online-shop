<?php
namespace Controller;
use Model\User;
use Model\Product;
use Model\UserProduct;
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

        // Инициализация массива товаров
        $products = []; // Инициализируем массив товаров

        if (!empty($userProducts)) {
            // Извлекаем идентификаторы продуктов
            $productIds = [];
            foreach ($userProducts as $userProduct) {
                $productIds[] = $userProduct->getProductId();
            }

            // Получаем все продукты по идентификаторам
            $productsDB = $this->productModel->getAllById($productIds);

            $productMap = [];
            foreach ($productsDB as $product) {
                $productMap[$product->getId()] = $product;
            }

            // Добавляем количество товаров в массив
            foreach ($userProducts as $userProduct) {
                $productId = $userProduct->getProductId();
                $amount = $userProduct->getAmount();

                // Проверяем, существует ли продукт в схеме productMap
                if (isset($productMap[$productId])) {
                    $productMap[$productId]-> setAmount($amount);  // добавляем количество как свойство
                    $products[] = $productMap[$productId];
                }
            }
        }

        require_once './../view/cart.php';
    }
//    public function removeProductFromCart(): void
//    {
//        $this->checkSession();
//
//        $userId = $_SESSION['user_id'];
//
//        $this->userProductModel->clearCartByUserId($userId);
//
//            header('Location: /cart');
//            exit();
//        }

    private function checkSession(): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header('Location: /login');
        }
    }
}



