<?php


namespace App\Repositories\Interfaces;


use App\Http\DTO\BooleanResponseDTOInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface MainRepositoryInterface
{
    public function save(array $modelItems): Model;

    public function update(Model $model, array $modelItems): bool;

    public function delete(Model $model): bool;

    public function getModel(): Model;

    public function findOrFail($id): Model;

    public function all(): Collection;
}
