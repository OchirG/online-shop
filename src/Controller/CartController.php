<?php
namespace Controller;
use Model\UserProduct;
use Service\Auth\AuthServiceInterface;
use Service\CartService;
class CartController
{
    private UserProduct $userProductModel;
    private CartService $cartService;
    private AuthServiceInterface $authService;


    public function __construct(CartService $cartService, AuthServiceInterface $authService, UserProduct $userProductModel)
    {
        $this->userProductModel = $userProductModel;
        $this->cartService = $cartService;
        $this->authService = $authService;

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



