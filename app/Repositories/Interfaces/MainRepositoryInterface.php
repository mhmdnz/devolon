<?php


namespace App\Repositories\Interfaces;


use Illuminate\Database\Eloquent\Model;

interface MainRepositoryInterface
{
    public function save(array $modelItems): Model;

    public function update(Model $model, array $modelItems): bool;

    public function delete(Model $model): bool;

    public function upsert(array $models): bool;

    public function getModel(): Model;
}
