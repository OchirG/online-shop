<?php
namespace Controller;

use Request\AddProductRequest;
use DataTransferObject\CartDTO;
use Service\AuthService;
use Service\CartService;

class UserProductController
{
    private CartService $cartService;
    private AuthService $authService;

    public function __construct()
    {
        $this->cartService = new CartService();
        $this->authService = new AuthService();
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

        $userId = $this->authService->getCurrentUser()->getId();
        $productId = $request->getProductId();
        $amount = $request->getAmount();

        $addProductDTO = new CartDTO($userId, $productId, $amount);

        if ($this->cartService->addProductToUserCart($addProductDTO)) {
            header('Location: /cart');
            exit();
        } else {
            $errors = 'Ошибка при добавлении продукта.';
            require_once './../view/catalog.php';
        }
    }

    private function checkSession(): void
    {
        session_start();
        if (!$this->authService->check()) {
            header('Location: /login');
        }
    }

}