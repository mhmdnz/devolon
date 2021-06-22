<?php


namespace App\Http\DTO;


interface ProductOfferRelationErrorDTOInterface
{
    public function setError(string $error);

    public function getError(): string;
}
