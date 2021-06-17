<?php


namespace App\Repositories\EloquentRepositories;


use App\Http\Requests\ProductCreateRequest;
use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ProductEloquentRepository extends MainEloquentRepository implements ProductRepositoryInterface
{
    public function __construct(protected Product $product)
    {
    }

    public function setModel(): Model
    {
        return $this->product;
    }
}
