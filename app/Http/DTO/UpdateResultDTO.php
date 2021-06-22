<?php


namespace App\Http\DTO;


class UpdateResultDTO implements UpdateResultDTOInterface
{
    private $result;

    public function setResult(bool $result): UpdateResultDTOInterface
    {
        $this->result = $result;

        return $this;
    }

    public function getResult(): bool
    {
        return $this->result;
    }
}
