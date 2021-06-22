<?php


namespace App\Repositories\Interfaces;


use App\Http\DTO\BooleanResponseDTOInterface;
use Illuminate\Database\Eloquent\Model;

interface MainRepositoryInterface
{
    public function save(array $modelItems): Model;

    public function update(Model $model, array $modelItems): BooleanResponseDTOInterface;

    public function delete(Model $model): BooleanResponseDTOInterface;

    public function getModel(): Model;

    public function find($id): Model;
}
