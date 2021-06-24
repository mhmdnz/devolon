<?php

namespace Tests\Unit;

use App\Models\Offer;
use App\Models\Product;
use App\Repositories\EloquentRepositories\ProductEloquentRepository;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProductEloquentRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    public function test_get_model(): void
    {
        $product = Product::factory()->make();
        $productEloquentRepository = new ProductEloquentRepository($product);
        $result = $productEloquentRepository->getModel();
        $this->assertEquals($result, $product);
    }

    public function test_get_offers(): void
    {
        $offer = Offer::factory()->create();
        $product = $offer->product;
        $productEloquentRepository = new ProductEloquentRepository($product);
        $result = $productEloquentRepository->getOffers($product);
        $this->assertEquals($product->offers, $result);
    }

    public function test_get_offers_by_quantity_limit(): void
    {
        $product = Product::factory()->create();
        Offer::factory()->count(2)->state(new Sequence(
            [
                'quantity' => 10,
            ],
            [
                'quantity' => 20
            ]
        ))->create([
            'product_id' => $product->id
        ]);
        $productEloquentRepository = new ProductEloquentRepository($product);
        $result = $productEloquentRepository->getOffersByQuantityLimit($product, 11);
        $this->assertCount(1, $result);
        $this->assertEquals($result[0]->quantity, 10);

        $result = $productEloquentRepository->getOffersByQuantityLimit($product, 21);
        $this->assertCount(2, $result);
        $this->assertEquals($result[1]->quantity, 20);
    }
}
