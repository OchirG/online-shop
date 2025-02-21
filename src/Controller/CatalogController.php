<?php
namespace Controller;
use Model\Product;
use Service\Auth\AuthServiceInterface;


class CatalogController
{
    private Product $productModel;
    private AuthServiceInterface $authService;

    public function __construct(Product $productModel, AuthServiceInterface $authService)
    {
        $this->productModel = $productModel;
        $this->authService = $authService;
    }

    // метод отвечает за отображение страницы каталога с продуктами
    public function getCatalogPage(): void
    {
        if ($this->authService->check()) {
            $products = $this->productModel->getAllProducts();

            if (empty($products)) {
                echo "Нет товаров в каталоге";
            } else {
                require_once './../view/catalog.php';
            }
        } else {
            header('Location: /login');
            exit();
        }
    }


}