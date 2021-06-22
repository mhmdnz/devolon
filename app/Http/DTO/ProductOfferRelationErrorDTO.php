<?php


namespace App\Http\DTO;


class ProductOfferRelationErrorDTO implements ProductOfferRelationErrorDTOInterface
{
    private string $error;

    public function getError(): string
    {
        return $this->error;
    }

    public function setError(string $error): void
    {
        $this->error = $error;
    }
}
