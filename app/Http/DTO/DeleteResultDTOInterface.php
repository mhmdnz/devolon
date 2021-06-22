<?php


namespace App\Http\DTO;


interface DeleteResultDTOInterface
{
    public function setResult(bool $result): DeleteResultDTOInterface;

    public function getResult(): bool;
}
