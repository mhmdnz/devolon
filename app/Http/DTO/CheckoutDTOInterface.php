<?php


namespace App\Http\DTO;


use Ramsey\Uuid\Type\Decimal;

interface CheckoutDTOInterface
{
    /**
     * @return mixed
     */
    public function getPrice(): int;

    /**
     * @param mixed $price
     */
    public function setPrice($price): void;

    /**
     * @return mixed
     */
    public function getDiscount(): int;

    /**
     * @param mixed $discount
     */
    public function setDiscount($discount): void;

    /**
     * @return array
     */
    public function jsonSerialize(): array;
}
