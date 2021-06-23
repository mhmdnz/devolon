<?php


namespace App\Http\DTO;


class DeleteResultDTO implements DeleteResultDTOInterface
{
    public function __construct(public string $result)
    {
    }
}
