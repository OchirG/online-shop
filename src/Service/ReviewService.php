<?php

namespace Service;
use Model\Product;
use Service\Auth\AuthServiceInterface;
use Model\Review;
use Request\ProductRequest;

class ReviewService
{
    private Product $productModel;
    private AuthServiceInterface $authService;

    public function __construct(Product $productModel, AuthServiceInterface $authService)
    {
        $this->productModel = $productModel;
        $this->authService = $authService;
    }

    public function getProductById(int $productId)
    {
        return $this->productModel->getOneById($productId);
    }

    public function getProductReviews(int $productId)
    {
        $reviews = Review::getAllByProductId($productId);
        $averageRating = Review::getAverageRating($productId);
        return [
            'reviews' => $reviews,
            'averageRating' => $averageRating
        ];
    }

    public function addReview(ProductRequest $request): string
    {
        $currentUser = $this->authService->getCurrentUser();
        if ($currentUser === null) {
            return "Необходима аутентификация.";
        }

        $userId = $currentUser->getId();
        $productId = $request->getProductId();

        if (!Review::userHasPurchasedProduct($userId, $productId)) {
            return "Вы не можете оставить отзыв на продукт, который вы не покупали.";
        }

        $comment = $request->getComment();
        $rating = $request->getRating();

        if (Review::create($userId, $productId, $rating, $comment)) {
            return "Отзыв успешно добавлен.";
        }

        return "Ошибка при добавлении отзыва";
    }
}