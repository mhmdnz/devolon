<?php

namespace App\Repositories\EloquentRepositories;

use Illuminate\Database\Eloquent\Model;

trait EloquentRepositoryTrait
{
    public function save(array $productItems): Model
    {
        return $this->getModel()::create($productItems);
    }

    public function update(Model $model, array $modelItems): bool
    {
        return $model->update($modelItems);
    }

    public function delete(Model $model): bool
    {
        return $model->delete();
    }

    public function upsert(array $models): bool
    {
        return $this->getModel()::upsert($models, 'name');
    }
}
