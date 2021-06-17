<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductInsertRequest;
use App\Services\Interfaces\ProductServiceInterface;
use Illuminate\Http\Request;

class ProductUpsertController extends Controller
{
    /**
     * ProductUpsertController constructor.
     * @param ProductServiceInterface $productService
     * @param ProductInsertRequest $productRequest
     */
    public function __construct(
        private ProductServiceInterface $productService,
        private ProductInsertRequest $productRequest
    )
    {
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $this->productService->upsert($this->productRequest->toArray());

        return response()->noContent();
    }
}
