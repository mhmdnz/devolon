<?php

namespace Tests\Unit;

use App\Http\DTO\CheckoutBestOfferDTO;
use App\Http\DTO\OfferDiscountDTO;
use App\Models\Offer;
use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\CheckoutService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Tests\TestCase;
use ReflectionClass;

class CheckoutServiceTest extends TestCase
{
    use DatabaseMigrations;

    private $checkoutService;

    public function test_get_without_offer_state_collection()
    {
        $product = Product::factory()->make();
        $getWithoutOfferStateCollectionMethod = $this->getMethod('getWithoutOfferStateCollection', $this->checkoutService);
        $result = $getWithoutOfferStateCollectionMethod->invokeArgs($this->checkoutService, [3, $product]);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertEquals($result['offerName'], CheckoutService::WITHOUT_OFFER_NAME);
        $this->assertEquals($result['quantity'], 3);
    }

    public function test_calculate_state_discount()
    {
        $checkoutBestOfferDTO = new CheckoutBestOfferDTO(
            'test',
            3,
            20,
            20
        );

        $calculateStateDiscountMethod = $this->getMethod('calculateStateDiscount', $this->checkoutService);
        $result = $calculateStateDiscountMethod->invokeArgs($this->checkoutService, [collect([$checkoutBestOfferDTO])]);

        $this->assertEquals($result, 20);
    }

    public function test_find_state_by_given_best_offer()
    {
        $product = Product::factory([
            'unit_price' => 20,
        ])->make();
        $offerDiscount = $this->getOfferDiscount();
        $findStateByGivenBestOfferMethod = $this->getMethod('findStateByGivenBestOffer', $this->checkoutService);
        $result = $findStateByGivenBestOfferMethod->invokeArgs($this->checkoutService, [
            $product,
            collect($offerDiscount),
            4,
            $offerDiscount
        ]);

        $this->assertCount(2, $result);
        $this->assertEquals($result[0]->offerName, 'firstOffer');
        $this->assertEquals($result[1]->offerName, CheckoutService::WITHOUT_OFFER_NAME);
    }

    public function test_find_best_offer()
    {
        $product = Product::factory([
            'unit_price' => 20,
        ])->make();
        $offerDiscount = $this->getOfferDiscount();
        $findBestOfferMethod = $this->getMethod('findBestOffer', $this->checkoutService);
        $result = $findBestOfferMethod->invokeArgs($this->checkoutService, [
            $product,
            collect([$offerDiscount]),
            4
        ]);

        $this->assertCount(2, $result);
        $this->assertEquals($result[0]->offerName, 'firstOffer');
        $this->assertEquals($result[1]->offerName, CheckoutService::WITHOUT_OFFER_NAME);
    }

    public function test_get_best_price()
    {
        $productRepositoryMock = \Mockery::mock(ProductRepositoryInterface::class)->makePartial();
        $offer = Offer::factory(1)->create();
        $productRepositoryMock->shouldReceive('getOffersByQuantityLimit')->andReturn($offer);
        $checkoutService = new CheckoutService($productRepositoryMock);

        $product = Product::factory([
            'unit_price' => 20,
        ])->create();

        $getBestPriceMethod = $this->getMethod('getBestPrice', $checkoutService);
        $result = $getBestPriceMethod->invokeArgs($checkoutService, [$product, 1]);

        $this->assertEquals($result['price'], 20);
    }

    public function test_calculate_checkout()
    {
        $product1 = Product::factory([
            'unit_price' => 20,
        ])->create();

        $productRepositoryMock = \Mockery::mock(ProductRepositoryInterface::class)->makePartial();
        $productRepositoryMock->shouldReceive('findOrFail')
            ->with($product1->id)
            ->andReturn($product1);

        $productRepositoryMock->shouldReceive('getOffersByQuantityLimit')
            ->withArgs([$product1, 3])
            ->andReturn(collect([]));

        $checkoutService = new CheckoutService($productRepositoryMock);
        $result = $checkoutService->calculateCheckout([
            ['id' => $product1->id],
            ['id' => $product1->id],
            ['id' => $product1->id]
        ]);

        $this->assertEquals($result->price, 60);
        $this->assertEquals($result->priceWithoutDiscount, 60);
        $this->assertCount(1, $result->offers);
    }

    public function setUp(): void
    {
        parent::setUp();
        $productRepositoryMock = \Mockery::mock(ProductRepositoryInterface::class)->makePartial();
        $checkoutService = new CheckoutService($productRepositoryMock);
        $this->checkoutService = $checkoutService;
    }

    private function getMethod($name, $class)
    {
        $class = new ReflectionClass($class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }

    private function getOfferDiscount(): OfferDiscountDTO
    {
        $offerDiscount = new OfferDiscountDTO(
            1,
            'firstOffer',
            3,
            16.66,
            50
        );

        return $offerDiscount;
    }
}
