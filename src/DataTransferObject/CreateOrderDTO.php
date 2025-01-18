<?php

namespace DataTransferObject;

class CreateOrderDTO
{
    public function __construct
    (private string $name,
     private string $email,
     private string $address,
     private string $number)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

}