<?php

namespace App\Repositories\EloquentRepositories;

use App\Http\DTO\BooleanResponseDTO;
use App\Http\DTO\BooleanResponseDTOInterface;
use Illuminate\Database\Eloquent\Model;

trait EloquentRepositoryTrait
{
    public function save(array $productItems): Model
    {
        return $this->getModel()::create($productItems);
    }

    public function update(Model $model, array $modelItems): BooleanResponseDTOInterface
    {
        return (new BooleanResponseDTO())->setResult($model->update($modelItems));
    }

    public function delete(Model $model): BooleanResponseDTOInterface
    {
        return (new BooleanResponseDTO())->setResult($model->delete());
    }

    public function find($id): Model
    {
        return $this->getModel()::find($id);
    }
}
