<?php
namespace Controller;
use Model\Product;
class CatalogController
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
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
        if(!isset($_SESSION['user_id'])){
            header('Location: /login');
        }
    }
}