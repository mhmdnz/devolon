<?php

namespace Tests\Unit;

use App\Http\DTO\DeleteResultDTO;
use App\Http\DTO\UpdateResultDTO;
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

    public function test_save(): void
    {
        $offer = Offer::factory()->make();
        $fakeArgs = ['test'];
        $offerRepository = \Mockery::mock(OfferRepositoryInterface::class)->makePartial();
        $offerRepository->shouldReceive('save')
            ->once()
            ->withArgs([$fakeArgs])
            ->andReturn($offer);
        $offerService = new OfferService($offerRepository);
        $result = $offerService->save($fakeArgs);
        $this->assertEquals($offer, $result);
    }

    public function test_update(): void
    {
        $offer = Offer::factory()->make();
        $expectedResult = new UpdateResultDTO(true);
        $fakeArgs = ['test'];
        $offerRepository = \Mockery::mock(OfferRepositoryInterface::class)->makePartial();
        $offerRepository->shouldReceive('update')
            ->once()
            ->withArgs([$offer, $fakeArgs])
            ->andReturnTrue();
        $offerService = new OfferService($offerRepository);
        $result = $offerService->update($offer, $fakeArgs);
        $this->assertEquals($expectedResult, $result);
    }

    public function test_delete(): void
    {
        $offer = Offer::factory()->make();
        $expectedResult = new DeleteResultDTO(true);
        $offerRepository = \Mockery::mock(OfferRepositoryInterface::class)->makePartial();
        $offerRepository->shouldReceive('delete')
            ->once()
            ->withArgs([$offer])
            ->andReturnTrue();
        $offerService = new OfferService($offerRepository);
        $result = $offerService->delete($offer);
        $this->assertEquals($expectedResult, $result);
    }

    public function test_find_or_fail(): void
    {
        $offer = Offer::factory()->make();
        $offerRepository = \Mockery::mock(OfferRepositoryInterface::class)->makePartial();
        $offerRepository->shouldReceive('findOrFail')
            ->once()
            ->withArgs([$offer->id])
            ->andReturn($offer);
        $offerService = new OfferService($offerRepository);
        $result = $offerService->findOrFail($offer->id);
        $this->assertEquals($offer, $result);
    }
}
