<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

trait ServiceTrait
{
    public function save(array $modelItems): Model
    {
        return $this->getModelRepository()->save($modelItems);
    }

    public function update(Model $model, array $modelItems): bool
    {
        return $this->getModelRepository()->update($model, $modelItems);
    }

    public function delete(Model $model): bool
    {
        return $this->getModelRepository()->delete($model);
    }

    public function upsert(array $models): bool
    {
        return $this->getModelRepository()->upsert($models);
    }
}
