<?php


namespace App\Services\Interfaces;


use Illuminate\Database\Eloquent\Model;

interface MainServiceInterface
{
    public function save(array $modelItems): Model;

    public function upsert(array $models): bool;

    public function update(Model $model, array $modelItems): bool;

    public function delete(Model $model): bool;
}
