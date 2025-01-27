<?php
namespace Controller;
use Model\Product;
use Service\AuthService;

class CatalogController
{
    private Product $productModel;
    private AuthService $authService;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->authService = new AuthService();
    }

    // метод отвечает за отображение страницы каталога с продуктами
    public function getCatalogPage(): void
    {
        $this->checkSession();

        $products = $this->productModel->getAllProducts();

        if (empty($products)) {
            echo "Нет товаров в каталоге";
        } else {
            require_once './../view/catalog.php';
        }
    }

    private function checkSession(): void
    {
        session_start();
        if(!$this->authService->check()){
            header('Location: /login');
        }
    }
}