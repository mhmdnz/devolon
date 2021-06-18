<?php

namespace App\Http\DTO;

use Ramsey\Uuid\Type\Decimal;

class CheckoutDTO implements CheckoutDTOInterface, \JsonSerializable
{
    private $price;
    private $discount;

    /**
     * @return mixed
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getDiscount(): int
    {
        return $this->discount;
    }

    /**
     * @param mixed $discount
     */
    public function setDiscount($discount): void
    {
        $this->discount = $discount;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'price' => $this->getPrice(),
            'discount' => $this->getDiscount()
        ];
    }
}
