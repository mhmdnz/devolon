<?php


namespace App\Services\Interfaces;


use App\Http\DTO\BooleanResponseDTOInterface;
use App\Repositories\Interfaces\MainRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface MainServiceInterface
{
    public function save(array $modelItems): Model;

    public function upsert(array $models): BooleanResponseDTOInterface;

    public function update(Model $model, array $modelItems): BooleanResponseDTOInterface;

    public function delete(Model $model): BooleanResponseDTOInterface;

    public function getModelRepository(): MainRepositoryInterface;
}
