<?php

namespace App\Services;

use App\Http\DTO\DeleteResultDTO;
use App\Http\DTO\DeleteResultDTOInterface;
use App\Http\DTO\UpdateResultDTO;
use App\Http\DTO\UpdateResultDTOInterface;
use Illuminate\Database\Eloquent\Model;

trait ServiceTrait
{
    public function save(array $modelItems): Model
    {
        return $this->getModelRepository()->save($modelItems);
    }

    public function update(Model $model, array $modelItems): UpdateResultDTOInterface
    {
        $updateResultDTO = new UpdateResultDTO();
        $updateResult = $this->getModelRepository()->update($model, $modelItems);

        return $updateResultDTO->setResult($updateResult);
    }

    public function delete(Model $model): DeleteResultDTOInterface
    {
        $deleteResultDTO = new DeleteResultDTO();
        $deleteResultDTO->setResult($this->getModelRepository()->delete($model));

        return $deleteResultDTO;
    }

    public function findOrFail($id): Model
    {
        return $this->getModelRepository()->findOrFail($id);
    }
}
