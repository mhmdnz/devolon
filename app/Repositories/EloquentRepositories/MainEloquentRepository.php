<?php


namespace App\Repositories\EloquentRepositories;


use App\Repositories\Interfaces\MainRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class MainEloquentRepository implements MainRepositoryInterface
{
    public function save(array $productItems): Model
    {
        return $this->setModel()::create($productItems);
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
        return $this->setModel()::upsert($models, 'name');
    }

    public abstract function setModel(): Model;
}
