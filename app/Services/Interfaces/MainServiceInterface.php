<?php


namespace App\Services\Interfaces;


use App\Http\DTO\DeleteResultDTOInterface;
use App\Http\DTO\UpdateResultDTOInterface;
use App\Repositories\Interfaces\MainRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface MainServiceInterface
{
    public function save(array $modelItems): Model;

    public function update(Model $model, array $modelItems): UpdateResultDTOInterface;

    public function delete(Model $model): DeleteResultDTOInterface;

    public function getModelRepository(): MainRepositoryInterface;

    public function findOrFail($id): Model;
}
