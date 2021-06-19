<?php


namespace App\Http\DTO;


interface BooleanResponseDTOInterface extends \JsonSerializable
{
    public function setResult(bool $result);
}
