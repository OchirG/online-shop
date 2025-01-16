<?php
namespace Controller;
use Model\UserProduct;
use Model\Product;
class UserProductController
{
    private UserProduct $userProductModel;
    private Product $productModel;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->productModel = new Product();
    }

    public function getAddProductForm(): void
    {
        $this->checkSession();
        require_once './../view/catalog.php';
    }

    public function handleAddUserProductForm(): void
    {
        $this->checkSession();
        $errors = $this->validateAddProductForm($_POST);

        if (!empty($errors)) {
            require_once './../view/catalog.php';
            return;
        }
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
        $userId = $_SESSION['user_id'];
        $productId = $_POST['product_id'];
        $amount = $_POST['amount'];

        if ($this->userProductModel->getAddProduct($userId, $productId, $amount)) {
            header('Location: /cart');
            exit();
        } else {
            $errors = 'Ошибка при добавлении продукта.';
        }

        require_once './../view/catalog.php';
    }

    private function checkSession(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
    }
    private function validateAddProductForm(array $data): array
    {
        $errors = [];

        if (isset($data['product_id'])) {
            $productId = $data['product_id'];
            if (empty($productId)) {
                $errors['product_id'] = 'Идентификатор продукта не может быть пустым';
            } elseif ($productId < 1) {
                $errors['product_id'] = 'Идентификатор продукта должен быть положительным';
            } elseif (!is_numeric($productId)) {
                $errors['product_id'] = 'Идентификатор продукта должен быть числом';
            } else {
                $productData = $this->productModel->getOneById($productId);
                if ($productData === false) {
                    $errors['product_id'] = "Данный товар отсутствует в магазине";
                }
            }
        } else {
            $errors['product_id'] = "Идентификатор продукта не передан";
        }

        if (isset($data['amount'])) {
            $amount = $data['amount'];
            if (empty($amount)) {
                $errors['amount'] = "Количество продуктов не должно быть пустым";
            } elseif ($amount < 1) {
                $errors['amount'] = "Количество продуктов должно быть положительным";
            } elseif (!is_numeric($amount)) {
                $errors['amount'] = "Количество продуктов должно быть числом";
            } elseif (floor($amount) != $amount) {
                $errors['amount'] = "Количество должно быть натуральным числом";
            }
        } else {
            $errors['amount'] = "Количество продуктов не передано";
        }

        return $errors;
    }
}