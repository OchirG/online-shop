<?php
namespace DataTransferObject;

class CartDTO
{
    private int $userId;
    private int $productId;
    private int $amount;

    public function __construct(int $userId, int $productId, int $amount)
    {
        $this->userId = $userId;
        $this->productId = $productId;
        $this->amount = $amount;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}


