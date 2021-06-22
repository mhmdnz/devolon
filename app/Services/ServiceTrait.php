<?php

namespace App\Services;

use App\Http\DTO\BooleanResponseDTOInterface;
use Illuminate\Database\Eloquent\Model;

trait ServiceTrait
{
    public function save(array $modelItems): Model
    {
        return $this->getModelRepository()->save($modelItems);
    }

    public function update(Model $model, array $modelItems): BooleanResponseDTOInterface
    {
        return $this->getModelRepository()->update($model, $modelItems);
    }

    public function delete(Model $model): BooleanResponseDTOInterface
    {
        return $this->getModelRepository()->delete($model);
    }
}
