<?php


namespace App\Http\DTO;


class DeleteResultDTO implements DeleteResultDTOInterface
{
    private bool $result = false;

    public function getResult(): bool
    {
        return $this->result;
    }

    public function setResult(bool $result): DeleteResultDTOInterface
    {
        $this->result = $result;

        return $this;
    }
}
