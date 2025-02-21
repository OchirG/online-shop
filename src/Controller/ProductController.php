<?php

namespace Controller;
use Request\ProductRequest;
use Service\ReviewService;

class ProductController
{
    private   ReviewService $productService;

    public function __construct(ReviewService $reviewService)
    {
        $this->productService = $reviewService;
    }

    public function getProductPage(ProductRequest $request): void
    {
        $productId = $request->getProductId();
        $product = $this->productService->getProductById($productId);
        if (!$product) {
            http_response_code(404);
            require_once './../view/404.php';
            return;
        }

        $productData = $this->productService->getProductReviews($productId);

        $reviews = $productData['reviews'];
        $averageRating = $productData['averageRating'];

        require_once './../view/product.php';
    }

    public function handleReviewForm(ProductRequest $request): void
    {
        $result = $this->productService->addReview($request);

        echo $result;
    }
}

