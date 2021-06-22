<?php


namespace App\Http\DTO;


interface UpdateResultDTOInterface
{
    public function setResult(bool $result): UpdateResultDTOInterface;

    public function getResult(): bool;
}
