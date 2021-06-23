<?php


namespace App\Http\DTO;


class UpdateResultDTO implements UpdateResultDTOInterface
{
    public function __construct(public string $result)
    {
    }
}
