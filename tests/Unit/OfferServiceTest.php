<?php

namespace Tests\Unit;

use App\Models\Offer;
use App\Models\Product;
use App\Repositories\Interfaces\OfferRepositoryInterface;
use App\Services\OfferService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class OfferServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function test_get_model_repository(): void
    {
        $offerRepository = \Mockery::mock(OfferRepositoryInterface::class)->makePartial();
        $offerService = new OfferService($offerRepository);
        $result = $offerService->getModelRepository();
        $this->assertEquals($result, $offerRepository);
    }

    public function test_save_on_product(): void
    {
        $offerRepository = \Mockery::mock(OfferRepositoryInterface::class)->makePartial();
        $offer = Offer::factory()->make();
        $product = Product::factory()->make();
        $offerItems = [
            'testItems'
        ];
        $offerRepository
            ->shouldReceive('saveOnProduct')
            ->once()
            ->withArgs([$product, $offerItems])
            ->andReturn($offer);
        $offerService = new OfferService($offerRepository);
        $result = $offerService->saveOnProduct($product, $offerItems);
        $this->assertEquals($result, $offer);
    }
}
