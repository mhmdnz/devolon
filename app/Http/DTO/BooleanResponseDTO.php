<?php


namespace App\Http\DTO;


class BooleanResponseDTO implements BooleanResponseDTOInterface
{
    private $result;

    public function setResult(bool $result)
    {
        $this->result = $result;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'action_result' => $this->result
        ];
    }
}
