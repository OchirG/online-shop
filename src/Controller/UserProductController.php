<?php
namespace Controller;
use Model\UserProduct;
use Request\AddProductRequest;

class UserProductController
{
    private UserProduct $userProductModel;


    public function __construct()
    {
        $this->userProductModel = new UserProduct();

    }

    public function getAddProductForm(): void
    {
        $this->checkSession();
        require_once './../view/catalog.php';
    }

    public function handleAddUserProductForm(AddProductRequest $request): void
    {
        $this->checkSession();
        $errors = $request->validate();

        if (!empty($errors)) {
            require_once './../view/catalog.php';
            return;
        }
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
        $userId = $_SESSION['user_id'];
        $productId = $request->getProductId();
        $amount = $request->getAmount();

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

}