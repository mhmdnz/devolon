<?php

namespace Tests\Unit;

use App\Models\Offer;
use App\Models\Product;
use App\Repositories\EloquentRepositories\OfferEloquentRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class OfferEloquentRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    public function test_get_model(): void
    {
        $offer = Offer::factory()->make();
        $offerEloquentRepository = new OfferEloquentRepository($offer);
        $result = $offerEloquentRepository->getModel();
        $this->assertEquals($result, $offer);
    }

    public function test_save_on_product(): void
    {
        $offer = Offer::factory()->create();
        $product = $offer->product;
        $expectedOffer = [
            'name' => 'offer_test',
            'quantity' => 2,
            'price' => 100
        ];
        $offerEloquentRepository = new OfferEloquentRepository($offer);
        $result = $offerEloquentRepository->saveOnProduct($product, $expectedOffer);
        $this->assertEquals($result->name, $expectedOffer['name']);
    }

    public function test_get_product(): void
    {
        $offer = Offer::factory()->create();
        $offerEloquentRepository = new OfferEloquentRepository($offer);
        $result = $offerEloquentRepository->getProduct($offer);
        $this->assertEquals($result, $offer->product);
    }
}
