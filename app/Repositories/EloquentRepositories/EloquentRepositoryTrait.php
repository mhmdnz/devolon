<?php

namespace App\Repositories\EloquentRepositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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

    public function findOrFail($id): Model
    {
        return $this->getModel()::findOrFail($id);
    }

    public function all(): Collection
    {
        return $this->getModel()::all();
    }
}
