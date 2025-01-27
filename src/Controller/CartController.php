<?php
namespace Controller;
use Model\UserProduct;
use Service\AuthService;
use Service\CartService;
class CartController
{
    private UserProduct $userProductModel;
    private CartService $cartService;
    private AuthService $authService;


    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->cartService = new CartService();
        $this->authService = new AuthService();

    }

    public function getCartPage(): void
    {
        $this->checkSession();

        $userId = $this->authService->getCurrentUser()->getId();
        $products = $this->cartService->getUserCartProducts($userId);

        require_once './../view/cart.php';
    }
    public function removeProductFromCart(): void
    {
        $this->checkSession();

        $userId = $this->authService->getCurrentUser()->getId();

        if (isset($_POST['product_id'])) {
            $productId = intval($_POST['product_id']);
            $this->userProductModel->removeProductFromCart($userId, $productId);
        }

        header('Location: /cart');
        exit();
    }

    private function checkSession(): void
    {
        session_start();
        if(!$this->authService->check()){
            header('Location: /login');
        }
    }
}



