<?php


namespace App\Services;


use App\Repositories\Interfaces\MainRepositoryInterface;
use App\Services\Interfaces\MainServiceInterface;
use Illuminate\Database\Eloquent\Model;

abstract class MainService implements MainServiceInterface
{
    public function save(array $modelItems): Model
    {
        return $this->setRepository()->save($modelItems);
    }

    public function update(Model $model, array $modelItems): bool
    {
        return $this->setRepository()->update($model, $modelItems);
    }

    public function delete(Model $model): bool
    {
        return $this->setRepository()->delete($model);
    }

    public function upsert(array $models): bool
    {
        return $this->setRepository()->upsert($models);
    }

    public abstract function setRepository(): MainRepositoryInterface;
}
